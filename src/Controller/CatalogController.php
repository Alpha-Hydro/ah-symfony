<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Service\CatalogService;
use App\Service\PdfService;
use App\Util\CatalogPdf;
use App\Util\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/catalog")
 * @Cache(expires="tomorrow", public=true)
 */
class CatalogController extends Controller
{
    /**
     * @Route("/{fullPath}", requirements={"fullPath": "[a-z0-9\-\/]+"}, name="catalog_list", methods="GET")
     * @param Categories $category
     * @param CatalogService $catalogService
     * @return Response
     */
    public function listCategories(Categories $category, CatalogService $catalogService): Response
    {
        $parentCategory = $category->getParent();

        $data = [
            'category' => $category,
            'breadcrumbs' => $catalogService->getBreadcrumbs($parentCategory),
            'parentCategory' => $parentCategory,
            'sidebarListCategories' => $catalogService->getSidebarListCategories($parentCategory),
        ];

        $childrenCategories = $catalogService->findByChildren($category);
        if(empty($childrenCategories))
            return $this->render('catalog/product_list.html.twig', $data);

        $data['categories'] = $childrenCategories;

        return $this->render('catalog/categories_list.html.twig', $data);
    }

    /**
     * @Route("/{fullPathCategory}/{path}",
     *     requirements={
     *          "fullPathCategory": "[a-z0-9\-\/]+",
     *          "path": "[A-Z0-9\-]+"
     *     },
     *     name="catalog_product_view", methods="GET")
     * @param Products $product
     * @param CatalogService $catalogService
     * @return Response
     */
    public function productView(Products $product, CatalogService $catalogService): Response
    {
        $category = $product->getCategory();
        $parentCategory = $category->getParent();

        $data= [
            'product' => $product,
            'category' => $category,
            'parentCategory' => $parentCategory,
            'sidebarListCategories' => $catalogService->getSidebarListCategories($parentCategory),
            'breadcrumbs' => $catalogService->getBreadcrumbs($category)
        ];

        return $this->render('catalog/product_view.html.twig', $data);
    }


    /**
     * @Route("/{fullPathCategory}/{path}.pdf",
     *     requirements={
     *          "fullPathCategory": "[a-z0-9\-\/]+",
     *          "path": "[A-Z0-9\-]+"
     *     },
     *     name="catalog_product_pdf", methods="GET")
     * @param Products $products
     * @param Request $request
     * @return Response
     */
    public function productPdf(Products $products, Request $request): Response
    {
        $html = $this->renderView('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
        ]);

        $pdf = new Pdf($products, $request);

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        return new Response($pdf->Output(), 200, [
            'Content-Type'          => 'application/pdf',
            'Content-Disposition'   => 'inline; filename="new.pdf"'
        ]);
    }
}
