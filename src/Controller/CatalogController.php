<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Modification;
use App\Entity\Products;
use App\Service\CategoriesService;
use App\Service\PassportPdf;
use App\Service\ProductPdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/catalog")
 * @Cache(expires="tomorrow", public=true)
 */
class CatalogController extends Controller
{
    /**
     * @Route("/{fullPath}", requirements={"fullPath": "[a-z0-9\-\_\/]+"}, name="catalog_list", methods="GET")
     * @param Categories $category
     * @param CategoriesService $catalogService
     * @return Response
     */
    public function listCategories(Categories $category, CategoriesService $catalogService): Response
    {
        $parentCategory = $category->getParent();

        $data = [
            'category' => $category,
            'breadcrumbs' => $catalogService->getBreadcrumbs($parentCategory),
            'parentCategory' => $parentCategory,
            'sidebarListCategories' => $catalogService->getSidebarListCategories($parentCategory),
        ];

        $childrenCategories = $catalogService->findByChildren($category);
        if (empty($childrenCategories))
            return $this->render('base/catalog/product_list.html.twig', $data);

        $data['categories'] = $childrenCategories;

        return $this->render('base/catalog/categories_list.html.twig', $data);
    }

    /**
     * @Route("/{fullPathCategory}/{path}",
     *     requirements={
     *          "fullPathCategory": "[a-z0-9\-\_\/]+",
     *          "path": "[A-Z0-9\-]+"
     *     },
     *     name="catalog_product_view", methods="GET")
     * @param Products $product
     * @param CategoriesService $catalogService
     * @return Response
     */
    public function productView(Products $product, CategoriesService $catalogService): Response
    {
        $category = $product->getCategory();
        $parentCategory = $category->getParent();

        $data = [
            'product' => $product,
            'category' => $category,
            'parentCategory' => $parentCategory,
            'sidebarListCategories' => $catalogService->getSidebarListCategories($parentCategory),
            'breadcrumbs' => $catalogService->getBreadcrumbs($category)
        ];

        return $this->render('base/catalog/product_view.html.twig', $data);
    }
}
