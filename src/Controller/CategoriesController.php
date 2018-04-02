<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories")
 */
class CategoriesController extends Controller
{
    /**
     * @Route("/", name="categories_index", methods="GET")
     * @param CategoriesRepository $categoriesRepository
     * @return Response
     */
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('categories/index.html.twig', ['categories' => $categoriesRepository->findByRootCategories()]);
    }

    /**
     * @Route("/{id}", name="categories_show", methods="GET")
     * @param Categories $category
     * @return Response
     */
    public function show(Categories $category): Response
    {
        return $this->render('categories/show.html.twig', ['category' => $category]);
    }
}
