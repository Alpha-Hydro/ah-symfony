<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
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
     * @param CategoriesRepository $categoriesRepository
     * @return Response
     */
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('index/index.html.twig', [
            'categories' => $categoriesRepository->findByRootCategories(),
        ]);
    }
}
