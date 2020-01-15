<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Tag;
use App\Form\PostFormType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findAll();

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

        $originalTags = new ArrayCollection();
        $originalTags = $post->getTags();

        $form = $this->createForm(PostFormType::class, $post);
        $form->get('tags')->setData($originalTags);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tags = $form->get('tags')->getData();
            $tagRepository = $em->getRepository(Tag::class);

            // remove tags
            foreach ($originalTags as $tag) {
                if (false == $form->get('tags')->getData()->contains($tag)) {
                    $post->removeTag($tag);
                }
            }

            foreach ($tags as $tag) {
                $tagRes = $tagRepository->findOneBy(['name' => $tag->getName()]);
                if ($tagRes) {
                    // add existing tags
                    $post->addTag($tagRes);
                } else {
                    // add new tags
                    $em->persist($tag);
                    $post->addTag($tag);
                }
            }
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
