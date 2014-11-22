<?php
namespace Neralind\UserBundle\Component\Authentication\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{

    protected $router;
    protected $security;

    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // redirect the user to where they were before the login process begun.
        if ($request->isXmlHttpRequest()) { 
          $user = $this->security->getToken()->getUser();
          $response = new Response();
          $response->headers->set('Content-Type', 'application/json');
          $response->setContent(json_encode(array(
                'user' => array(
                    'id' => $user->getId(),
                    'username' => $user->getUsername()
                )
            )));
        }
        else { 
            $response = new RedirectResponse( $this->router->generate('homepage')); 
        }

        return $response;
    }
}