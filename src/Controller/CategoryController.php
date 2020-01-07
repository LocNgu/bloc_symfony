<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    public function index()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAllOrderedByName();

        return $this->render(
            'admin/category/category.html.twig',
            ['categories' => $categories]
        );
    }
    public function create(Request $request)
    {
        $category = new Category('');

        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category');
        }

        return  $this->render('admin/category/createCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, $categoryId)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($categoryId);
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category');
        }

        return $this->render('admin/category/createCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete($categoryId)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($categoryId);
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('category');
    }

    public function getPosts($categoryId)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findAllByCategory($categoryId);

        return $this->render(
            'admin/post.html.twig',
            ['posts' => $posts]
        );
    }
}
