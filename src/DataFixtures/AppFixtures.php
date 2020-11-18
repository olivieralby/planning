<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
         $user = new User();
         $user->setFirstname('Chloe');
         $user->setLastname('Alby');
         $user->setPassword($this->encoder->encodePassword($user,'ao11chloe'));
         $user->setEmail('chloe@gmail.com');
         $user->setRoles(['ROLE_ADMIN']);
         $manager->persist($user);
         $manager->flush();
    }
}
