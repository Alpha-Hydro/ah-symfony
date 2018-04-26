<?php

namespace App\Controller;

use App\Service\CatalogService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @param CatalogService $catalogService
     * @return Response
     */
    public function index(Request $request, CatalogService $catalogService): Response
    {
        $data = [
            'categories' => $catalogService->getSidebarListCategories(),
            'searchQuery' => ''
        ];

        if ($query = $request->get("query")){
            $data['searchQuery'] = $query;
            $data['productList'] = $catalogService->findProductBySearchQuery($query);
            //die(var_dump($data['productList']));
        }



        return $this->render('search/index.html.twig', $data);
    }
}
