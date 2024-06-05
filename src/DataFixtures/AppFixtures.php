<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // Propriété pour stocker l'encodeur de mot de passe
    private $password;

    // Constructeur pour injecter l'encodeur de mot de passe
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->password = $passwordEncoder;
    }

    // Méthode pour charger les fixtures
    public function load(ObjectManager $manager): void
    {
        // Création d'un nouvel utilisateur Admin
        $user = new Admin();
        $user->setUsername("admin");

        // Hashage du mot de passe
        $password = $this->password->hashPassword($user, 'password123@');
        $user->setPassword($password);

        // Définition de l'email de l'utilisateur
        $user->setEmail("admin@gmail.com");

        // Définition des rôles de l'utilisateur
        $user->setRoles(array('ROLE_SUPER_ADMIN'));

        // Définition des autres attributs de l'utilisateur
        $user->setNom('admin');
        $user->setPrenom('admin');
        $user->setTelephone("0745628555");

        // Persistance de l'utilisateur dans la base de données
        $manager->persist($user);
        $manager->flush();
    }
}
