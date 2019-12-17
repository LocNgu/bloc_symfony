<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoleController extends AbstractController
{
    public function index()
    {
        return $this->render(
            'admin/user/role.html.twig'
        );
    }
}