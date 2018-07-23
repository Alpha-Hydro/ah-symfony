<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 22.07.2018
 * Time: 15:10
 */

namespace App\Controller\Api;


use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/categories")
 */
class CategoriesController extends Controller
{
    /**
     * @Route("/{id}", methods="GET")
     * @param Categories $category
     * @param CategoriesRepository $categoriesRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function listChildren(Categories $category, CategoriesRepository $categoriesRepository, Request $request): JsonResponse
    {

        $data = [
            'category' => $category,
            'currentId' =>  $request->query->get('current'),
            'parent' => $category->getParent(),
            'categories' => $categoriesRepository->findByChildren($category)
        ];

        $html = $this->render('api/categories/categories_list.html.twig', $data);

        return $this->json($html);
    }

    /**
     * @Route(methods="GET")
     * @param CategoriesRepository $categoriesRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function listRootCategories(CategoriesRepository $categoriesRepository, Request $request): JsonResponse
    {
        $data = [
            'currentId' =>  $request->query->get('current'),
            'categories' => $categoriesRepository->findByRootCategories()
        ];

        return $this->json($this->render('api/categories/categories_list.html.twig', $data));
    }
}