<?php

namespace App\Controller\Crud;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products")
 */
class ProductsController extends AbstractController
{
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
}
