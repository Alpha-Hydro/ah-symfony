<?php

namespace App\Controller\Admin\User;

use App\Entity\User;
use App\Form\User\UserNewType;
use App\Form\User\UserType;
use App\Repository\UserRepository;
use DateTime;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/admin/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index", methods="GET")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Swift_Mailer $mailer
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, Swift_Mailer $mailer): Response
    {
        $user = new User();
        $user->setCreateDate(new \DateTime("now"));
        $user->setUpdateDate(new \DateTime("now"));

        $form = $this->createForm(UserNewType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $message = (new Swift_Message('Новый пользователь'))
                ->setFrom($this->getParameter('swiftmailer.sender_address'))
                ->addCc($this->getParameter('swiftmailer.sender_address'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail/new_user.html.twig',
                        ['user' => $user, 'password' => $user->getPlainPassword()]
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/success", name="user_success", methods={"GET"})
     */
    public function actionsSuccess(): Response
    {
        return $this->render('admin/user/success.html.twig');
    }


    /**
     * @Route("/{id}", name="user_show", methods="GET")
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdateDate(new DateTime('now'));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/change_password", name="user_change_password", methods="GET|POST")
     * @param Request $request
     * @param User $user
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Swift_Mailer $mailer
     * @return Response
     */
    public function changePassword(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder, Swift_Mailer $mailer): Response
    {
        $form = $this->createFormBuilder()
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 6, 'minMessage' => 'Пароль должен быть не менее 6-ти символов']),
                ],
                'invalid_message' => 'Повтор введенного пароля не совпадает',
                'required' => true,
                'first_options' => ['label' => 'Новый пароль'],
                'second_options' => ['label' => 'Повторите новый пароль'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();

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
                        ['user' => $user, 'password' => $newPassword]
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', "Пароль успешно изменен... На email: " . $user->getEmail() . "выслан новый пароль!");
            return $this->redirectToRoute('user_success');
        }

        return $this->render('admin/user/change_password.html.twig',
            [
                'user' => $user,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
