<?php

namespace App\Controller;

use App\Service\CategoriesService;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @param CategoriesService $catalogService
     * @param ProductService $productService
     * @return Response
     */
    public function index(Request $request, CategoriesService $catalogService, ProductService $productService): Response
    {
        $data = [
            'categories' => $catalogService->getSidebarListCategories(),
            'searchQuery' => ''
        ];

        if ($query = $request->get("query")){
            $data['searchQuery'] = $query;
            $data['productList'] = $productService->findProductBySearchQuery($query);
            //die(var_dump($data['productList']));
        }



        return $this->render('base/search/index.html.twig', $data);
    }
}
