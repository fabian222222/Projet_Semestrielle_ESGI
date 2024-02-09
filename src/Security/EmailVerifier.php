<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getId(),
            $user->getEmail()
        );

        $context = $email->getContext();
        //dd($signatureComponents->getExpirationMessageKey(), $signatureComponents->getExpirationMessageData());
        $context['signedUrl'] = $signatureComponents->getSignedUrl();

        // Convertion des résultats de la méthode getExpirationMessageKey en français
        switch ($signatureComponents->getExpirationMessageKey()) {
            case '%count% year|%count% years':
                $context['expiresAtMessageKey'] = '%count% année |%count% années';
                break;
            case '%count% month|%count% months':
                $context['expiresAtMessageKey'] = '%count% mois |%count mois%';
                break;
            case '%count% day|%count% days':
                $context['expiresAtMessageKey'] = '%count% jour |%count jours%';
                break;
            case '%count% hour|%count% hours':
                $context['expiresAtMessageKey'] = '%count% heure |%count% heures';
                break;
            case '%count% minute|%count% minutes':
                $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
                break;
        }

        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, UserInterface $user): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
