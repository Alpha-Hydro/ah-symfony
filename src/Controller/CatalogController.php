<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use App\Service\CatalogService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/catalog")
 * @Cache(expires="tomorrow", public=true)
 */
class CatalogController extends AbstractController
{
    /**
     * @Route("/", name="catalog_index", methods="GET")
     * @param CategoriesRepository $categoriesRepository
     * @return Response
     */
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $categories = $categoriesRepository->findByRootCategories();

        return $this->render('catalog/categories_list.html.twig', [
            'categories' => $categoriesRepository->findByRootCategories(),
            'sidebarListCategories' => $categories,
        ]);
    }

    /**
     * @Route("/{fullPath}", requirements={"fullPath": "[a-z0-9\-\/]+"}, name="catalog_list", methods="GET")
     * @param Categories $category
     * @param CatalogService $catalogService
     * @return Response
     */
    public function listCategories(Categories $category, CatalogService $catalogService): Response
    {
        $parentCategory = $category->getParent();

        $data = [
            'category' => $category,
            'breadcrumbs' => $catalogService->getBreadcrumbs($parentCategory),
            'parentCategory' => $parentCategory,
            'sidebarListCategories' => $catalogService->getSidebarListCategories($parentCategory),
        ];

        $childrenCategories = $catalogService->findByChildren($category);
        if(empty($childrenCategories))
            return $this->render('catalog/product_list.html.twig', $data);

        $data['categories'] = $catalogService->findByChildren($category);

        return $this->render('catalog/categories_list.html.twig', $data);
    }

    /**
     * @Route("/{fullPathCategory}/{path}",
     *     requirements={
     *          "fullPathCategory": "[a-z0-9\-\/]+",
     *          "path": "[A-Z0-9\-]+"
     *     },
     *     name="catalog_product_view", methods="GET")
     * @param Products $product
     * @param CatalogService $catalogService
     * @return Response
     */
    public function productView(Products $product, CatalogService $catalogService): Response
    {
        $category = $product->getCategory();
        $parentCategory = $category->getParent();

        $data= [
            'product' => $product,
            'category' => $category,
            'parentCategory' => $parentCategory,
            'sidebarListCategories' => $catalogService->getSidebarListCategories($parentCategory),
            'breadcrumbs' => $catalogService->getBreadcrumbs($category)
        ];

        return $this->render('catalog/product_view.html.twig', $data);
    }
}
