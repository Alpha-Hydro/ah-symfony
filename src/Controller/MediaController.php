<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\MediaCategories;
use App\Service\MediaService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MediaController
 * @package App\Controller
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
    public function listPosts(MediaCategories $category, MediaService $mediaService): Response
    {
        $data = [
            'category' => $category,
            'sidebarListCategories' => $mediaService->findByRootCategories(),
            'posts' => $mediaService->findByPostsCriteria($category),
        ];

        return $this->render('base/media/categories_list.html.twig', $data);
    }

    /**
     * @Route("/{pathCategory}/{path}",
     *     requirements={
     *          "pathCategory": "news|article|action",
     *          "path": "[a-z0-9\_]+"
     *      }, name="media_post_view", methods="GET")
     * @param Media $media
     * @param MediaService $mediaService
     * @return Response
     */
    public function viewPost(Media $media, MediaService $mediaService): Response
    {
        $data = [
            'category' => $media->getCategory(),
            'post' => $media,
            'sidebarListCategories' => $mediaService->findByRootCategories(),
        ];

        return $this->render('base/media/post_view.html.twig', $data);
    }

}
