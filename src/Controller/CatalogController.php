<?php

namespace App\Controller;

use App\Entity\Categories;
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

        return $this->render('catalog/index.html.twig', [
            'categories' => $categoriesRepository->findByRootCategories(),
            'sidebarListCategories' => $categories,
        ]);
    }

    /**
     * @Route("/{fullPath}", requirements={"fullPath": "[\w\-\/]+"}, name="catalog_list", methods="GET")
     * @param Categories $category
     * @param CatalogService $catalogService
     * @return Response
     */
    public function list(Categories $category, CatalogService $catalogService): Response
    {
        $parentCategory = $category->getParent();

        $data = [
            'category' => $category,
            'breadcrumbs' => $catalogService->getBreadcrumbs($parentCategory),
            'parentCategory' => $parentCategory,
            'sidebarListCategories' => $catalogService->getSidebarListCategories($parentCategory),
        ];

        return $this->render('catalog/index.html.twig', $data);
    }
}
