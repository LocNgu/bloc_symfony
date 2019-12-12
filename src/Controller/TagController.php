<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    public function index()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository(Tag::class)->findAll();

        return $this->render(
            'admin/admin.html.twig',
            ['tags' => $tags]
        );
    }
}
