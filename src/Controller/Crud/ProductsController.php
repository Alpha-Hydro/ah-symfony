<?php

namespace App\Controller\Crud;

use App\Entity\ProductDraft;
use App\Entity\ProductImages;
use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use App\Service\UploadImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products")
 */
class ProductsController extends AbstractController
{
    const UPLOAD_PATH = '/upload/products/';
    const UPLOAD_PATH_DRAFT = '/upload/products/draft/';

    /**
     * @Route("/", name="products_index", methods="GET")
     * @param ProductsRepository $productsRepository
     * @return Response
     */
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('admin/products/index.html.twig', [
            'products' => $productsRepository->findAll(),
            'pageTitle' => 'Продукция'
        ]);
    }

    /**
     * @Route("/archive", name="products_archive", methods="GET")
     * @param ProductsRepository $productsRepository
     * @return Response
     */
    public function archive(ProductsRepository $productsRepository): Response
    {
        return $this->render('admin/products/index.html.twig', [
            'products' => $productsRepository->findBy(['deleted' => true]),
            'pageTitle' => 'Архив продукции'
        ]);
    }

    /**
     * @Route("/{id}/archive", name="products_check_archive", methods="GET")
     * @param Products $products
     * @param Request $request
     * @return Response
     */
    public function checkArchive(Products $products, Request $request): Response
    {
        $isDeleted = $products->isDeleted();

        $products->setDeleted(!$isDeleted);

        if ($isDeleted === true) {
            $products->setActive(false);
        }

        dd($request->get('_route'));

//        $em = $this->getDoctrine()->getManager();
//        $em->flush();
//
//        return $this->redirectToRoute($request->get('_route'));

    }

    /**
     * @Route("/disabled", name="products_disabled", methods="GET")
     * @param ProductsRepository $productsRepository
     * @return Response
     */
    public function disabled(ProductsRepository $productsRepository): Response
    {
        return $this->render('admin/products/index.html.twig', [
            'products' => $productsRepository->findBy(['active' => false]),
            'pageTitle' => 'Скрытая продукция'
        ]);
    }

    /**
     * @Route("/{id}/disabled", name="products_check_active", methods="GET")
     * @param Products $products
     * @param Request $request
     * @return Response
     */
    public function checkActive(Products $products, Request $request): Response
    {
        $isActive = $products->isActive();

        $products->setActive(!$isActive);

        dd($request->get('_route'));

//        $em = $this->getDoctrine()->getManager();
//        $em->flush();
//
//        return $this->redirectToRoute($request->get('_route'));

    }

    /**
     * @Route("/new", name="products_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('products_index');
        }

        return $this->render('admin/products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="products_show", methods="GET")
     * @param Products $product
     * @return Response
     */
    public function show(Products $product): Response
    {
        return $this->render('admin/products/show.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/{id}/edit", name="products_edit", methods="GET|POST")
     * @param Request $request
     * @param Products $product
     * @return Response
     */
    public function edit(Request $request, Products $product): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('products_index', ['id' => $product->getId()]);
        }

        return $this->render('admin/products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="products_delete", methods="DELETE")
     * @param Request $request
     * @param Products $product
     * @return Response
     */
    public function delete(Request $request, Products $product): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('products_index');
    }


    /**
     * @Route("/{id}/draft", name="products_draft", methods={"POST"})
     * @param Request $request
     * @param Products $product
     * @param UploadImageService $uploadImageService
     * @return JsonResponse|RedirectResponse
     */
    public function uploadDraft(Request $request, Products $product, UploadImageService $uploadImageService)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('imageUpload');

        if (null != $file) {
            $fileName = $uploadImageService->upload($file, $this->getParameter('upload_products_draft'));

            // @Todo delete old file
            $image = $product->getFileDraft() ?? new ProductDraft();
            $image->setFileName($fileName);
            $product
                ->setFileDraft($image)
                // @Todo template is draft file name ???
                ->setDraft($fileName)
                ->setUploadPathDraft(self::UPLOAD_PATH_DRAFT);
        }

        $this->getDoctrine()->getManager()->flush();

        if ($request->isXmlHttpRequest()) {
            return $this->json($file->getClientOriginalName());
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/{id}/delete_draft", name="products_delete_draft", methods={"POST"})
     * @param Request $request
     * @param Products $product
     * @param UploadImageService $uploadImageService
     * @return JsonResponse|RedirectResponse
     */
    public function deleteDraft(Request $request, Products $product, UploadImageService $uploadImageService)
    {
        $result = true;

        $fileDraft = $product->getFileDraft();
        if (null != $fileDraft) {
            $filePath = $this->getParameter('upload_products_draft') . DIRECTORY_SEPARATOR . $fileDraft->getFileName();
            $result = $uploadImageService->delete($filePath);

            $product->setFileDraft(null);
        }

        $draft = $product->getDraft();
        if (null != $draft) {
            $filePath = $product->getUploadPathDraft() . $draft;
            $result = $uploadImageService->delete($filePath);

            $product->setDraft(null)->setUploadPathDraft(null);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->remove($fileDraft);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            return $this->json($result);
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/{id}/image", name="products_image", methods={"POST"})
     * @param Request $request
     * @param Products $product
     * @param UploadImageService $uploadImageService
     * @return JsonResponse|RedirectResponse
     */
    public function uploadImage(Request $request, Products $product, UploadImageService $uploadImageService)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('imageUpload');

        if (null != $file) {
            $fileName = $uploadImageService->upload($file, $this->getParameter('upload_products'));

            // @Todo delete old file
            $image = $product->getFileImage() ?? new ProductImages();
            $image->setFileName($fileName);
            $product
                ->setFileImage($image)
                // @Todo template is draft file name ???
                ->setImage($fileName)
                ->setUploadPath(self::UPLOAD_PATH);
        }

        $this->getDoctrine()->getManager()->flush();

        if ($request->isXmlHttpRequest()) {
            return $this->json($file->getClientOriginalName());
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/{id}/delete_image", name="products_delete_image", methods={"POST"})
     * @param Request $request
     * @param Products $product
     * @param UploadImageService $uploadImageService
     * @return JsonResponse|RedirectResponse
     */
    public function deleteImage(Request $request, Products $product, UploadImageService $uploadImageService)
    {
        $result = true;

        $fileImage = $product->getFileImage();
        if (null != $fileImage) {
            $filePath = $this->getParameter('upload_products') . DIRECTORY_SEPARATOR . $fileImage->getFileName();
            $result = $uploadImageService->delete($filePath);

            $product->setFileImage(null);
        }

        $image = $product->getImage();
        if (null != $image) {
            $filePath = $product->getUploadPath() . $image;
            $result = $uploadImageService->delete($filePath);

            $product->setImage(null)->setUploadPath(null);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->remove($fileImage);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            return $this->json($result);
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
