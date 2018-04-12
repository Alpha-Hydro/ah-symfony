<?php

namespace App\Controller;

use App\Repository\ModuleSiteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wandfluh")
 * @Cache(expires="tomorrow", public=true)
 */

class WandfluhController extends AbstractController
{
    /**
     * @Route("/", name="wandfluh")
     * @param ModuleSiteRepository $moduleSiteRepository
     * @return Response
     */
    public function index(ModuleSiteRepository $moduleSiteRepository): Response
    {
        $page = $moduleSiteRepository->findOneBy(['path' => 'wandfluh']);

        return $this->render('wandfluh/index.html.twig', [
            'page' => $page,
        ]);
    }
}
