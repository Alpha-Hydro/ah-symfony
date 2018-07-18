<?php

namespace App\Controller;

use Swift_Mailer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MailController extends Controller
{
    /**
     * @Route("/mail", name="mail")
     * @param Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('mvl@alpha-hydro.com')
            ->setTo('admin@alpha-hydro.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'mail/index.html.twig',
                    ['controller_name' => 'MailController']
                ),
                'text/html'
            )
        ;

        $mailer->send($message);

        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }
}
