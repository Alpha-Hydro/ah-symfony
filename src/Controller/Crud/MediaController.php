<?php

namespace App\Controller\Crud;

use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
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
     * @return Response
     */
    public function new(Request $request): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/{id}", name="media_show", methods="GET")
     * @param Media $medium
     * @return Response
     */
    public function show(Media $medium): Response
    {
        return $this->render('admin/media/show.html.twig', ['medium' => $medium]);
    }

    /**
     * @Route("/{id}/edit", name="media_edit", methods="GET|POST")
     * @param Request $request
     * @param Media $medium
     * @return Response
     */
    public function edit(Request $request, Media $medium): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('media_edit', ['id' => $medium->getId()]);
        }

        return $this->render('admin/media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
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

        if ($isDeleted === true){
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
        if ($this->isCsrfTokenValid('delete'.$medium->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medium);
            $em->flush();
        }

        return $this->redirectToRoute('media_index');
    }
}
