<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 27.07.2018
 * Time: 2:10
 */

namespace App\Controller\Admin\Security;


use App\Entity\ChangeUserPassword;
use App\Form\User\ChangeUserPasswordType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Security("has_role('ROLE_ADMIN')")
     *
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
            ->add('email', EmailType::class, ['empty_data' => 'you@email.com'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $userRepository->findOneBy(['email' => $data['email']]);

            if (!$user) {
                $this->addFlash('danger', 'Пользователя с таким e-mail не существует');
            } else {
                $newPassword = $this->randomPassword();
                $password = $passwordEncoder->encodePassword($user, $newPassword);
                $user->setPassword($password);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $message = (new Swift_Message('Recovery Password'))
                    ->setFrom($this->getParameter('swiftmailer.sender_address'))
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'mail/recovery_password.html.twig',
                            ['user' => $user, 'new_password' => $newPassword]
                        ),
                        'text/html'
                    );

                $mailer->send($message);

                $this->addFlash('success', "На указанный Вами email выслан новый пароль!");
                return $this->redirectToRoute('password_actions_success');
            }

        }

        return $this->render(
            'admin/registration/change_recovery_password.html.twig',
            ['form' => $form->createView(), 'label_button' => 'Запросить новый пароль']
        );

    }


    /**
     * @Route("/change", name="change_password", methods="GET|POST")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Swift_Mailer $mailer
     * @return RedirectResponse|Response
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, Swift_Mailer $mailer): Response
    {
        $changePasswordModel = new ChangeUserPassword();
        $form = $this->createForm(ChangeUserPasswordType::class, $changePasswordModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $newPassword = $changePasswordModel->getNewPassword();

            $password = $passwordEncoder->encodePassword($user, $newPassword);
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $message = (new Swift_Message('Смена пароля.'))
                ->setFrom($this->getParameter('swiftmailer.sender_address'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail/change_password.html.twig',
                        ['user' => $user, 'new_password' => $newPassword]
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', "На Ваш email выслан новый пароль!");
            return $this->redirectToRoute('password_actions_success');
        }

        return $this->render('admin/registration/change_recovery_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/success", name="password_actions_success")
     */
    public function recoverySuccess()
    {
        return $this->render('admin/registration/password_success.html.twig');
    }


    /**
     * @return string
     * @throws \Exception
     */
    private function randomPassword(): string
    {
        $bytes = random_bytes(4);
        return bin2hex($bytes);
    }

}