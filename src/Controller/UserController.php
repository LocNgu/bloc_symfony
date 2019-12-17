<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        return $this->render(
            'admin/user/user.html.twig',
            ['users' => $users]
        );
    }

    public function edit(Request $request, $userId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($userId);

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');
        }
        return $this->render('admin/user/editUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
