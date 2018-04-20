<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Service\CatalogService;
use App\Service\ModuleSiteService;
use App\Service\WandfluhService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Cache(expires="tomorrow", public=true)
 */
class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @param CatalogService $catalogService
     * @return Response
     */
    public function index(CatalogService $catalogService): Response
    {
        return $this->render('index/index.html.twig', [
            'categories' => $catalogService->findByRootCategories(),
        ]);
    }

    /**
     * @Route("/catalog", name="catalog_index")
     * @param CatalogService $catalogService
     * @return Response
     */
    public function indexCatalog(CatalogService $catalogService): Response
    {
        $categories = $catalogService->findByRootCategories();

        return $this->render('catalog/categories_list.html.twig', [
            'categories' => $categories,
            'sidebarListCategories' => $categories,
        ]);
    }

    /**
     * @Route("/wandfluh", name="wandfluh_index")
     * @param ModuleSiteService $moduleSiteService
     * @param WandfluhService $wandfluhService
     * @return Response
     */
    public function indexWandfluh(ModuleSiteService $moduleSiteService, WandfluhService $wandfluhService): Response
    {
        return $this->render('wandfluh/index.html.twig', [
            'page' => $moduleSiteService->getPageByPath('wandfluh'),
            'sidebarListCategories' => $wandfluhService->findByRootCategories(),
        ]);
    }

    /**
     * @Route("/manufacture", name="manufacture_index")
     */
    public function indexManufacture(): Response
    {
        return $this->render('manufacture/index.html.twig', [
            'controller_name' => 'ManufactureController',
        ]);
    }
}
