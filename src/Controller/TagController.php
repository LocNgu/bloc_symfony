<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository(Tag::class)->findAll();

        return $this->render(
            'admin/admin.html.twig',
            ['tags' => $tags]
        );
    }
}
