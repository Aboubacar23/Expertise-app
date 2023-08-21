<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


class MailerService
{
    public function __construct(private MailerInterface $mailer){}

    public function sendEmail($email, $subject,$message,$router,$user,$cdp,$num_affaire): void
    {
        $email = (new TemplatedEmail())
            ->from('esayticexpertise@gmail.com')
            ->to($email)
            ->subject($subject)
            ->htmlTemplate($router)
            ->context([
                'message'=> $message,
                'users' => $user,
                'cpd' => $cdp,
                'num_affaire' => $num_affaire
            ]);
        
        $this->mailer->send($email);
    }
}