<?php
namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    public function index()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findAllPublic();

//        dump($posts);
        return $this->render(
            'blog/blog.html.twig',
            ['posts' => $posts]
        );
    }
}
