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
        $role_admin = new Role('ROLE_ADMIN');
        $role_user = new Role('ROLE_USER');
        $role_author = new Role('ROLE_AUTHOR');


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

        $user = new User();
        $user->setUsername('user');
        $user->setRole($role_admin);
        $user->setRole($role_user);
        $user->setEmail('user@user.com');
        $user->setFirstname('us');
        $user->setLastname('er');
        $user->setPassword($this->passwordEncoder->encodePassword(
           $user,
           'user'
        ));
        $manager->persist($user);

        $user = new User();
        $user->setUsername('walterwriter');
        $user->setRole($role_user);
        $user->setRole($role_author);
        $user->setEmail('walter@writer.com');
        $user->setFirstname('walter');
        $user->setLastname('writer');
        $user->setPassword($this->passwordEncoder->encodePassword(
           $user,
           'user'
        ));
        $manager->persist($user);

        $user = new User();
        $user->setUsername('authorarthur');
        $user->setRole($role_user);
        $user->setRole($role_author);
        $user->setEmail('author@arthur.com');
        $user->setFirstname('author');
        $user->setLastname('arthur');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'user'
        ));
        $manager->persist($user);

        $manager->flush();
    }
}
