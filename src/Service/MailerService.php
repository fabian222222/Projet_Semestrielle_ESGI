<?php

namespace App\Service;

use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerService
{
    public function sendConfirmationMail(EmailVerifier $emailVerifier, String $emailSender, String $logoPath , User $user) : void
    {
        $emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address($emailSender, 'BotMailAE'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
                ->embed(fopen($logoPath, 'r'), 'img'));
    }
}