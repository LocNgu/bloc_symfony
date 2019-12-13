<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        return $this->render(
            'admin/user/user.html.twig',
            ['users' => $users]
        );
    }
}
