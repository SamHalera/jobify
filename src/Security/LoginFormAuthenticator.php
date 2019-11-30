<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * 
     *
     * @var UserRepository
     */
    private $userRepository;

    private $router;
    
    public function __construct(UserRepository $userRepository, RouterInterface $router)
    {
        $this->userRepository = $userRepository;
        $this->router = $router;
    }
    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'app_login'
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        
        $credentials=  [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password')
        ];

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
        
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->userRepository->findOneBy(['email' => $credentials['email']]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        //TODO PASSWORD CHECK

        return true;
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('app_home'));
    }

    public function getLoginUrl()
    {

        return $this->router->generate('app_login');
    }


    /**
     * Get the value of userRepository
     */ 
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * Set the value of userRepository
     *
     * @return  self
     */ 
    public function setUserRepository($userRepository)
    {
        $this->userRepository = $userRepository;

        return $this;
    }

    /**
     * Get the value of router
     */ 
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Set the value of router
     *
     * @return  self
     */ 
    public function setRouter($router)
    {
        $this->router = $router;

        return $this;
    }
}
