<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @Route("/catalog")
 */
class CatalogController extends Controller
{
    /**
     * @Route("/", name="catalog_index", methods="GET")
     * @param CategoriesRepository $categoriesRepository
     * @return Response
     */
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('catalog/index.html.twig', [
            'categories' => $categoriesRepository->findByRootCategories(),
        ]);
    }

    /**
     * @Route("/{fullPath}", requirements={"fullPath": "[\w\-\/]+"}, name="catalog_list", methods="GET")
     * @param Categories $category
     * @return Response
     */
    public function list(Categories $category): Response
    {
        return $this->render('catalog/index.html.twig', [
            'category' => $category,
            'breadcrumbs' =>  $this->getBreadcrumbs($category->getParent())
        ]);
    }

    public function getBreadcrumbs(Categories $category = null){
        if ($category == null)
            return null;

        $result = [];
        do{
            $result[] = $category;
            $category = $category->getParent();
        }
        while($category != null);

        if (!empty($result))
            $result = array_reverse($result);

        return $result;
    }
}
