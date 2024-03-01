<?php

namespace App\Service;

use App\Entity\Contract;
use App\Entity\Invoice;
use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

class MailerService
{
    public function __construct(private MailerInterface $mailer){}
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

    public function sendContract(String $emailSender, String $logoPath, $contract, String $filePath, String $type) : void
    {
        $template = '';
        if ($type == 'Invoice') {
            $template = 'invoice/mail.html.twig';
        } else {
            $template = 'contract/mail.html.twig';
        }

        $client = $contract->getClient();
        $drivingSchool = $contract->getDrivingSchool();

        $email = (new TemplatedEmail())
            ->from(new Address($emailSender, 'BotMailAE'))
            ->to($client->getEmail())
            ->subject("Facture")
            ->htmlTemplate($template)
            ->context([
                'clientName' => $client->getFirstname(),
                'contractName' => $contract->getName(),
                'drivingSchoolName' => $drivingSchool->getName()
                ])
            ->embed(fopen($logoPath, 'r'), 'img')
            ->addPart(new DataPart(new File($filePath)))
        ;
        $this->mailer->send($email);
    }
}