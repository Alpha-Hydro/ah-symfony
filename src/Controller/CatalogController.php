<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Service\CatalogService;
use App\Service\PassportPdf;
use App\Service\ProductPdf;
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
        if (empty($childrenCategories))
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

        $data = [
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
        $pdf = new ProductPdf($products, $request);

        $pdf->AddPage();

        $pdf->showImages()
            ->showParams()
            ->showDescription()
            ->showModifications()
            ->showNote();

        return new Response($pdf->Output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="product.pdf"'
        ]);
    }

    /**
     * @Route("/{fullPathCategory}/{path}/passport.pdf",
     *     requirements={
     *          "fullPathCategory": "[a-z0-9\-\/]+",
     *          "path": "[A-Z0-9\-]+"
     *     },
     *     name="passport_product_pdf", methods="GET")
     * @param Products $products
     * @param Request $request
     * @return Response
     */
    public function passportPdf(Products $products, Request $request): Response
    {
        $pdf = new PassportPdf($products, $request);

        $pdf->AddPage();

        $pdf->showName()
            ->showDescription()
            ->showImages()
            ->showParams()
            ->showModifications()
            ->showNote('ГАРАНТИЙНЫЕ ОБЯЗАТЕЛЬСТВА', 'Компания гарантирует работоспособность указанных изделий в течение 1 (года) с момента изготовления. При обнаружении скрытого дефекта в период гарантийного срока фирма обязуется безвозмездно заменить изделие. Организация не несет ответственности за убытки, причиненные неисправностью установленного изделия. Гарантия не распространяется на изделия неправильно установленные или поврежденные механическими и химическими воздействиями, а так же, эксплуатируемыми в условиях не соответствующих указанным в настоящем паспорте.');

        return new Response($pdf->Output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="passport.pdf"'
        ]);
    }
}
