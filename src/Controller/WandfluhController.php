<?php

namespace App\Controller;

use App\Entity\WfCategory;
use App\Service\ModuleSiteService;
use App\Service\WandfluhService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wandfluh")
 * @Cache(expires="tomorrow", public=true)
 */

class WandfluhController extends AbstractController
{
    /**
     * @Route("/{fullPath}", requirements={"fullPath": "[a-z0-9\-\/]+"}, name="wf_category_list", methods="GET")
     * @param WfCategory $category
     * @param WandfluhService $wandfluhService
     * @return Response
     */
    public function listCategories(WfCategory $category, WandfluhService $wandfluhService)
    {
        $parentCategory = $category->getParent();

        $data = [
            'category' => $category,
            'breadcrumbs' => $wandfluhService->getBreadcrumbs($parentCategory),
            'parentCategory' => $parentCategory,
            'sidebarListCategories' => $wandfluhService->getSidebarListCategories($parentCategory),
        ];

        $childrenCategories = $wandfluhService->findByChildren($category);

        if(empty($childrenCategories)){
            $data['productList'] = $wandfluhService->groupProductsByControl($category);
            return $this->render('wandfluh/product_list.html.twig', $data);
        }


        $data['categories'] = $childrenCategories;

        return $this->render('wandfluh/categories_list.html.twig', $data);
    }
}
