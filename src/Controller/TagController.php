<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Tag;
use App\Form\TagFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TagController extends AbstractController
{
    public function index()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository(Tag::class)->findAllOrderedByName();

        return $this->render(
            'admin/tag/tag.html.twig',
            ['tags' => $tags]
        );
    }

    public function create(Request $request)
    {
        $tag = new Tag('');

        $form = $this->createForm(TagFormType::class, $tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('tag');
        }

        return  $this->render('admin/tag/createTag.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, $tagId)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository(Tag::class)->find($tagId);
        $form = $this->createForm(TagFormType::class, $tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('tag');
        }

        return $this->render('admin/tag/createTag.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete($tagId)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository(Tag::class)->find($tagId);
        $em->remove($tag);
        $em->flush();

        return $this->redirectToRoute('tag');
    }

    public function getPosts($tagId)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findAllByTag($tagId);

        return $this->render(
            'admin/post/post.html.twig',
            ['posts' => $posts]
        );
    }
}
