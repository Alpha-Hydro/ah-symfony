<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Service\CategoriesService;
use App\Service\ManufactureService;
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
     * @param CategoriesService $catalogService
     * @return Response
     */
    public function index(CategoriesService $catalogService): Response
    {
        return $this->render('base/index/index.html.twig', [
            'categories' => $catalogService->findByRootCategories(),
        ]);
    }

    /**
     * @Route("/catalog", name="catalog_index")
     * @param CategoriesService $catalogService
     * @return Response
     */
    public function indexCatalog(CategoriesService $catalogService): Response
    {
        $categories = $catalogService->findByRootCategories();

        return $this->render('base/catalog/categories_list.html.twig', [
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
        return $this->render('base/wandfluh/index.html.twig', [
            'page' => $moduleSiteService->getPageByPath('wandfluh'),
            'sidebarListCategories' => $wandfluhService->findByRootCategories(),
        ]);
    }

    /**
     * @Route("/manufacture", name="manufacture_index")
     * @param ModuleSiteService $moduleSiteService
     * @param ManufactureService $manufactureService
     * @return Response
     */
    public function indexManufacture(ModuleSiteService $moduleSiteService, ManufactureService $manufactureService): Response
    {
        return $this->render('base/manufacture/index.html.twig', [
            'page' => $moduleSiteService->getPageByPath('manufacture'),
            'sidebarListCategories' => $manufactureService->findByRootCategories(),
        ]);
    }
}
