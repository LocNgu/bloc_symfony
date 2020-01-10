<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\RoleFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends AbstractController
{
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $roles = $em->getRepository(Role::class)->findAll();

        return $this->render(
            'admin/user/role.html.twig',
            ['roles' => $roles]
        );
    }

    public function getUsers($roleId)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findByRole($roleId);

        return $this->render(
            'admin/user/user.html.twig',
            ['users' => $users]
        );
    }

    public function create(Request $request)
    {
        $role = new Role('');

        $form = $this->createForm(RoleFormType::class, $role);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $role = $form->getData();
            $name = $form->get('name')->getData();
            $role->setName($name);
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute('role');
        }

        return  $this->render('admin/user/createRole.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, $roleId)
    {
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository(Role::class)->find($roleId);
        $form = $this->createForm(RoleFormType::class, $role);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $role = $form->getData();
            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute('role');
        }

        return  $this->render('admin/user/createRole.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, $roleId)
    {
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository(Role::class)->find($roleId);
        $em->remove($role);
        $em->flush();

        return $this->redirectToRoute('role');
    }
}
