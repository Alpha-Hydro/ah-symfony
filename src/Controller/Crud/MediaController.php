<?php

namespace App\Controller\Crud;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Cocur\Slugify\SlugifyInterface;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/media")
 */
class MediaController extends Controller
{
    /**
     * @Route("/", name="media_index", methods="GET")
     * @param MediaRepository $mediaRepository
     * @return Response
     */
    public function index(MediaRepository $mediaRepository): Response
    {
        $posts = $mediaRepository->findByActive();
        return $this->render('admin/media/index.html.twig', ['media' => $posts]);
    }

    /**
     * @Route("/new", name="media_new", methods="GET|POST")
     * @param Request $request
     * @param SlugifyInterface $slug
     * @param MediaRepository $mediaRepository
     * @return Response
     */
    public function new(Request $request, SlugifyInterface $slug, MediaRepository $mediaRepository): Response
    {
        $medium = new Media();
        $medium->setCreateDate(new DateTime('now'));
        //$medium->setUpdateDate(new DateTime('now'));

        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medium->setAuthor($this->getUser());

            $path = $slug->slugify($medium->getName(), '_');
            if (false === $this->isUniquePath($path)) {
                $path .= '_' . date('Ymd');
            }
            $medium->setPath($path);

            $fullPath = (null != $medium->getCategory()->getFullPath()) ? $medium->getCategory()->getFullPath() . '/' . $path : $path;
            $medium->setFullPath($fullPath);

            $em = $this->getDoctrine()->getManager();
            $em->persist($medium);
            $em->flush();

            return $this->redirectToRoute('media_index');
        }

        return $this->render('admin/media/new.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="media_edit", methods="GET|POST")
     * @param Request $request
     * @param Media $medium
     * @param SlugifyInterface $slug
     * @return Response
     */
    public function edit(Request $request, Media $medium, SlugifyInterface $slug): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$medium->setUpdateDate(new DateTime('now'));
            $medium->setAuthor($this->getUser());

            $path = $slug->slugify($medium->getName(), '_');
            if (false === $this->isUniquePath($path)) {
                $path .= '_' . date('Ymd');
            }
            $medium->setPath($path);
            $fullPath = (null != $medium->getCategory()->getFullPath()) ? $medium->getCategory()->getFullPath() . '/' . $path : $path;
            $medium->setFullPath($fullPath);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('media_index');
        }

        return $this->render('admin/media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/archive", name="media_archive", methods="GET")
     * @param MediaRepository $mediaRepository
     * @return Response
     */
    public function archive(MediaRepository $mediaRepository): Response
    {
        return $this->render('admin/media/index.html.twig', [
            'media' => $mediaRepository->findByIsDeleted(),
            'pageTitle' => 'Архив публикаций'
        ]);
    }

    /**
     * @Route("/disabled", name="media_disabled", methods="GET")
     * @param MediaRepository $mediaRepository
     * @return Response
     */
    public function disabled(MediaRepository $mediaRepository): Response
    {
        return $this->render('admin/media/index.html.twig', [
            'media' => $mediaRepository->findByIsDisabled(),
            'pageTitle' => 'Скрытые публикации'
        ]);
    }


    /**
     * @Route("/{id}", name="media_show", methods="GET")
     * @param Media $medium
     * @return Response
     */
    public function show(Media $medium): Response
    {
        return $this->render('admin/media/show.html.twig', ['medium' => $medium]);
    }

    /**
     * @Route("/{id}/active", name="media_check_active", methods="GET")
     * @param Media $media
     * @return Response
     */
    public function checkActive(Media $media): Response
    {
        $isActive = $media->isActive();

        $media->setActive(!$isActive);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('media_index');
    }

    /**
     * @Route("/{id}/archive", name="media_check_archive", methods="GET")
     * @param Media $media
     * @return Response
     */
    public function checkArchive(Media $media): Response
    {
        $isDeleted = $media->isDeleted();
        $media->setDeleted(!$isDeleted);

        if ($isDeleted === false) {
            $media->setActive(false);
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('media_index');
    }

    /**
     * @Route("/{id}", name="media_delete", methods="DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Media $medium
     * @return Response
     */
    public function delete(Request $request, Media $medium): Response
    {
        if ($this->isCsrfTokenValid('delete' . $medium->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medium);
            $em->flush();
        }

        return $this->redirectToRoute('media_index');
    }

    private function isUniquePath(string $path, int $id = null): bool
    {
        $em = $this->getDoctrine()->getRepository(Media::class);

        $media = $em->findOneBy(['path' => $path]);

        if (null != $media) {
            if ($id != null && $media->getId() == $id) {
                return true;
            }
            return false;
        }
        return true;
    }
}
