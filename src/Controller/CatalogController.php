<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use App\Service\CatalogService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->render('catalog/catalog_categories_list.html.twig', [
            'categories' => $categoriesRepository->findByRootCategories(),
            'sidebarListCategories' => $categories,
        ]);
    }

    /**
     * @Route("/{fullPath}", requirements={"fullPath": "[\w\-\/]+"}, name="catalog_list", methods="GET")
     * @param string $fullPath
     * @param CatalogService $catalogService
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function listCategories(string $fullPath, CatalogService $catalogService): Response
    {
        $category = $catalogService->findByFullPath($fullPath);

        if (null === $category)
            return $this->forward('App\Controller\CatalogController:productView', ['fullPath' => $fullPath]);

        $parentCategory = $category->getParent();

        $data = [
            'category' => $category,
            'breadcrumbs' => $catalogService->getBreadcrumbs($parentCategory),
            'parentCategory' => $parentCategory,
            'sidebarListCategories' => $catalogService->getSidebarListCategories($parentCategory),
        ];

        $childrenCategories = $catalogService->findByChildren($category);
        if(empty($childrenCategories))
            return $this->render('catalog/catalog_product_list.html.twig', $data);

        $data['categories'] = $catalogService->findByChildren($category);

        return $this->render('catalog/catalog_categories_list.html.twig', $data);
    }

    /**
     * @Route("/{fullPath}", requirements={"fullPath": "[\w\-\/]+"}, name="catalog_product_view", methods="GET")
     * @param Products $product
     */
    public function productView(Products $product)
    {
        die(var_dump($product->getName()));
    }
}
