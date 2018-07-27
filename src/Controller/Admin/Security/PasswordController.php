<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 27.07.2018
 * Time: 2:10
 */

namespace App\Controller\Admin\Security;


use App\Repository\UserRepository;
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
     * @return Response
     */
    public function recoveryPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository): Response
    {
        /*$userLogin = $request->request->get('email');
        $user = $userRepository->findOneBy(['email' => $userLogin]);*/

        $form = $this->createFormBuilder()
            ->add('email', EmailType::class)
            ->getForm();


        return $this->render(
            'admin/registration/recovery.html.twig',
            ['form' => $form->createView()]
        );

    }

}