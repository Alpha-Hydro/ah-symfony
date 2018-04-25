<?php

namespace App\Controller;

use App\Entity\Manufacture;
use App\Entity\ManufactureCategories;
use App\Service\ManufactureService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/manufacture")
 * @Cache(expires="tomorrow", public=true)
 */
class ManufactureController extends Controller
{
    /**
     * @Route("/{fullPath}", requirements={"fullPath": "[a-z]+"}, name="manufacture_list", methods="GET")
     * @param ManufactureCategories $category
     * @param ManufactureService $manufactureService
     * @return Response
     */
    public function listProducts(ManufactureCategories $category, ManufactureService $manufactureService): Response
    {
        $data = [
            'category' => $category,
            'sidebarListCategories' => $manufactureService->findByRootCategories()
        ];

        return $this->render('manufacture/manufacture_list.html.twig', $data);
    }


    /**
     * @Route("/{pathCategory}/{path}",
     *     requirements={
     *          "pathCategory": "[a-z]+",
     *          "path": "[a-z0-9\_]+"
     *     }, name="manufacture_product_view", methods="GET")
     * @param Manufacture $manufacture
     * @param ManufactureService $manufactureService
     * @return Response
     */
    public function viewProduct(Manufacture $manufacture, ManufactureService $manufactureService)
    {
        $data = [
            'category' => $manufacture->getCategory(),
            'product' => $manufacture,
            'sidebarListCategories' => $manufactureService->findByRootCategories()
        ];

        return $this->render('manufacture/product_view.html.twig', $data);
    }
}
