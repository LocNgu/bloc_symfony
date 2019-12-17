<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    public function index()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render(
            'admin/category.html.twig',
            ['categories' => $categories]
        );
    }
}
