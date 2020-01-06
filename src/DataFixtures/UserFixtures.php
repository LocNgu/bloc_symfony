<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setRole($role_admin);
        $user->setEmail('admin@admin.com');
        $user->setFirstname('ad');
        $user->setLastname('min');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin'
        ));
        $manager->persist($user);

//        $user = new User();
//        $user->setUsername('user');
//        $user->addRole($role_user);
//        $user->setEmail('user@user.com');
//        $user->setFirstname('us');
//        $user->setLastname('er');
//        $user->setPassword($this->passwordEncoder->encodePassword(
//            $user,
//            'user'
//        ));
//        $manager->persist($user);
//
//        $user = new User();
//        $user->setUsername('user2');
//        $user->setEmail('john@doe.com');
//        $user->setFirstname('john');
//        $user->setLastname('doe');
//        $user->setPassword($this->passwordEncoder->encodePassword(
//            $user,
//            'user'
//        ));
//        $manager->persist($user);
//
//        $user = new User();
//        $user->setUsername('user3');
//        $user->setEmail('jane@doe.com');
//        $user->setFirstname('jane');
//        $user->setLastname('doe');
//        $user->setPassword($this->passwordEncoder->encodePassword(
//            $user,
//            'user'
//        ));
//        $manager->persist($user);

        $manager->flush();
    }
}
