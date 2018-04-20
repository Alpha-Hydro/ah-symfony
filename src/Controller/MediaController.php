<?php

namespace App\Controller;

use App\Entity\MediaCategories;
use App\Service\MediaService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MediaController
 * @package App\Controller
 *
 * @Cache(expires="tomorrow", public=true)
 */
class MediaController extends Controller
{

    /**
     * @Route("/{path}", requirements={"path":"news|article|action"}, name="media_category_list", methods="GET")
     * @param MediaCategories $category
     * @param MediaService $mediaService
     * @return Response
     */
    public function listNews(MediaCategories $category, MediaService $mediaService): Response
    {
        $data = [
            'category' => $category,
            'sidebarListCategories' => $mediaService->findByRootCategories(),
        ];

        return $this->render('media/categories_list.html.twig', $data);
    }
}
