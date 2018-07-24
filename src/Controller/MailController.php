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
            ->setFrom($this->getParameter('swiftmailer.sender_address'))
            ->setTo('mvl@alpha-hydro.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'mail/test.html.twig'
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
