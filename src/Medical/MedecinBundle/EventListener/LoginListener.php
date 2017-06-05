<?php

namespace Medical\MedecinBundle\EventListener;



use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use User\UserBundle\Entity\Utilisateur;

class LoginListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $tokenStorage;
    private $router;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->tokenStorage = $container->get('security.token_storage');
        $this->router = $container->get('router');


    }

    public function onKernelRequest(FilterControllerEvent $event)
    {

//
//        if(is_null($this->isUserLogged() )){
//            $response = new RedirectResponse($this->router->generate('fos_user_security_login'));
//            $event->setResponse($response);
//        }
    }

    private function isUserLogged()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        return ($user instanceof Utilisateur)?$user:null;
    }

    private function isAuthenticatedUserOnAnonymousPage($currentRoute)
    {
        return in_array(
            $currentRoute,
            ['fos_user_security_login', 'fos_user_resetting_request', 'app_user_registration']
        );
    }
}