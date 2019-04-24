<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;

/**
 * @property  jwtManager
 */
class JWTCreatedListener{

    /**
     * @var RequestStack
     */
    private $requestStack ;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {

        /** @var $user \App\Entity\User */
        $user = $event->getUser();

        $payload['userId'] = $user->getId();
        $payload['username']= $user->getName();
        $payload['email']=$user->getEmail();
        $payload['credit'] = $user->getCredit();
        $payload['date'] = $user->getCreatedAt();

        $event->setData($payload);

    }

}