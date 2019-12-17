<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    public function index()
    {
        return $this->render(
            'admin/post.html.twig'
        );
    }
}
