<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    private $userPasswordEncoderInterface;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->userPasswordEncoderInterface = $userPasswordEncoderInterface;
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     *
     */
    public function logout()
    {
        
    }

    /**
     * @Route("/password", name="app_generate_password")
     *
     * 
     */
    public function getEncodedPassword()
    {
        $user = new User();
        $password = $this->userPasswordEncoderInterface->encodePassword(
            $user,
            'hello'
        );

        return $this->render('password.html.twig',
            ['password' => $password]
        );
    }

    /**
     * Get the value of userPasswordEncoderInterface
     */ 
    public function getUserPasswordEncoderInterface()
    {
        return $this->userPasswordEncoderInterface;
    }

    /**
     * Set the value of userPasswordEncoderInterface
     *
     * @return  self
     */ 
    public function setUserPasswordEncoderInterface($userPasswordEncoderInterface)
    {
        $this->userPasswordEncoderInterface = $userPasswordEncoderInterface;

        return $this;
    }
}
