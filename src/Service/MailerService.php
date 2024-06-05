<?php

namespace App\Service;

use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    // Constructeur avec injection de dépendance pour le MailerInterface
    public function __construct(private MailerInterface $mailer){}

    // Méthode pour envoyer un email
    public function sendEmail($email, $subject, $message, $router, $user, $cdp, $num_affaire): void
    {
        // Création d'un nouvel email avec un modèle
        $email = (new TemplatedEmail())
            // Définition de l'expéditeur
            ->from(new Address('base.expertise.jeumont@gmail.com', 'Base Expertise'))
            // Définition du destinataire
            ->to($email)
            // Définition du sujet de l'email
            ->subject($subject)
            // Définition du template HTML pour l'email
            ->htmlTemplate($router)
            // Définition du contexte pour les variables du template
            ->context([
                'message' => $message,
                'users' => $user,
                'cpd' => $cdp,
                'num_affaire' => $num_affaire
            ]);

        // Envoi de l'email
        $this->mailer->send($email);
    }
}
