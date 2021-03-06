<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Récupère des données additionnelles au token lorque que l'utilisateur est logué via JWT (voir services.yaml)
 */
class AuthenticationSuccessListener
{

    public function __construct (SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstname' => $user->getFirstname(),
            'roles' => $user->getRoles(),
            'lastname' => $user->getLastname(),
            'birthDate' => $user->getBirthDate(),
            'status' => $user->getStatus(),
            'phone' => $user->getPhone(),
            'iban' => $user->getIban(),
            'bic' => $user->getBic()


        ];

        $event->setData($data);
    }
}