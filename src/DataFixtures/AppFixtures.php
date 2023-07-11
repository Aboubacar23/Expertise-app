<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{ 
    private $password;
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->password = $passwordEncoder;
    }

   public function load(ObjectManager $manager): void
   {
        $user = new Admin();
        $user->SetUsername("admin");
        $password = $this->password->hashPassword($user, 'password123@');
        $user->SetPassword($password); 
        $user->SetEmail("admin@gmail.com");
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $user->setNom('admin');
        $user->setPrenom('admin');
        $user->setTelephone("0745628555");

        $manager->persist($user);
        $manager->flush();
   }
}
