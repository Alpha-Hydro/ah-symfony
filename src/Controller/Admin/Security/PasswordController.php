<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 27.07.2018
 * Time: 2:10
 */

namespace App\Controller\Admin\Security;


use App\Repository\UserRepository;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/password")
 * Class PasswordController
 * @package App\Controller\Admin\Security
 */
class PasswordController extends Controller
{

    /**
     * @Route("/recovery", name="recovery_password", methods="GET|POST")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     * @param Swift_Mailer $mailer
     * @return Response
     * @throws \Exception
     */
    public function recoveryPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository, Swift_Mailer $mailer): Response
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();


            $user = $userRepository->findOneBy(['email' => $data['email']]);

            if (!$user) {
                $this->addFlash('danger', 'Пользователя с таким e-mail не существует');
            } else {
                $bytes = random_bytes(4);
                $password = $passwordEncoder->encodePassword($user, bin2hex($bytes));
                $user->setPassword($password);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $message = (new \Swift_Message('Recovery Password'))
                    ->setFrom($this->getParameter('swiftmailer.sender_address'))
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'mail/recovery_password.html.twig',
                            ['user' => $user, 'new_password' => bin2hex($bytes)]
                        ),
                        'text/html'
                    );

                $mailer->send($message);

                $this->addFlash('success', "На указанный Вами email выслан новый пароль!");
                //return $this->redirectToRoute('password_actions_success');
            }

        }

        return $this->render(
            'admin/registration/recovery.html.twig',
            ['form' => $form->createView()]
        );

    }

    /**
     * @Route("/success", name="password_actions_success")
     */
    public function recoverySuccess()
    {
        return $this->render('admin/registration/recovery_success.html.twig');
    }

}