<?php

namespace App\Controller;

use App\Entity\WfCategory;
use App\Repository\ModuleSiteRepository;
use App\Repository\WfCategoryRepository;
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
     * @Route("/", name="wandfluh_index", methods="GET")
     * @param ModuleSiteRepository $moduleSiteRepository
     * @param WandfluhService $wandfluhService
     * @return Response
     */
    public function index(ModuleSiteRepository $moduleSiteRepository, WandfluhService $wandfluhService): Response
    {
        return $this->render('wandfluh/index.html.twig', [
            'page' => $moduleSiteRepository->findOneBy(['path' => 'wandfluh']),
            'sidebarListCategories' => $wandfluhService->findByRootCategories(),
        ]);
    }

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
