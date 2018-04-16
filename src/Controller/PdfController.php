<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PdfController extends Controller
{
    /**
     * @Route("/pdf", name="pdf")
     * @return Response
     */
    public function index(): Response
    {
        $html = $this->renderView('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
        ]);

        $pdf = $this->container->get('tcpdf');

        // @Todo set fonts
        $pdf->SetFont('dejavusanscondensed', '', 12, '', false);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        return new Response($pdf->Output(), 200, [
            'Content-Type'          => 'application/pdf',
            'Content-Disposition'   => 'inline; filename="new.pdf"'
        ]);
    }
}
