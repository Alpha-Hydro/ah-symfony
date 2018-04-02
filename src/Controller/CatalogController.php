<?php

namespace App\Controller;

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
            'controller_name' => self::class,
            'categories' => $categoriesRepository->findByRootCategories(),
        ]);
    }
}
