<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

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
     * @Route("/register", name="app_register")
     *
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $formAuthenticator)
    {
        if($request->isMethod('POST')){

            $user = new User();

            
            $user->setFirstname($request->request->get('firstname'));
            $user->setLastname($request->request->get('lastname'));
            $user->setEmail($request->request->get('email'));
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $request->request->get('password')
            ));

            if($request->request->get('candidate')){
                $user->setRoles(["ROLE_CANDIDATE"]);
            } elseif($request->request->get('recruiter')) {
                $user->setRoles(["ROLE_RECRUITER"]);
            }
            $em->persist($user);
            $em->flush();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $formAuthenticator,
                'main'
            );

        }
        return $this->render('security/register.html.twig');
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
