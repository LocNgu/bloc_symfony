<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Tag;
use App\Form\PostFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findAll();
        dump($posts);

        return $this->render(
            'admin/post/post.html.twig',
            ['posts' => $posts]
        );
    }

    public function create(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
//            $post->addTag(new Tag($form->get('newTag')->getData()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post');
        }

        return $this->render('admin/post/createPost.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, $postId)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($postId);

        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post');
        }

        return $this->render(
            'admin/post/editPost.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    public function delete($postId)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($postId);
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('post');
    }
}
