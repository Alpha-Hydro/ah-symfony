<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends Controller
{
    /**
     * @Route("/pdf", name="pdf")
     * @Security("is_granted('ROLE_USER')")
     * @return Response
     */
    public function view(): Response
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

    /**
     * @Route("/pdf/create", name="pdf-create")
     * @Security("has_role('ROLE_MANAGER')")
     * @return Response
     */
    public function create(): Response
    {
        return new Response('<html><body>Create PDF page! </body></html>');
    }

    /**
     * @Route("/pdf/delete", name="pdf-delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @return Response
     */
    public function delete(): Response
    {
        return new Response('<html><body>Delete PDF page! </body></html>');
    }


}
