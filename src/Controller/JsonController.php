<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JsonController extends AbstractController
{
    public function index()
    {
        return $this->render(
            'admin/admin.html.twig'
        );
    }
}
