<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        return new Response($pdf->Output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="new.pdf"'
        ]);
    }
}
