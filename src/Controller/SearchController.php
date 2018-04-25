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
        ];

        if ($query = $request->get("query"))
            $data['productList'] = $catalogService->findProductBySearchQuery($query);

        return $this->render('search/index.html.twig', $data);
    }
}
