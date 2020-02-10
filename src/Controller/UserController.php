<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
            $user = $form->getData();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render(
            'admin/user/editUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, $userId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($userId);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user');
    }

    public function serialize()
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();

        $encoders = [new JsonEncoder()];

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object, $format, $context){
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES => [
                'id',
                'username',
                'email',
                'firstname',
                'lastname',
                'roles' => ['id']
            ]
        ];

        $normalizers = [new ObjectNormalizer(null, null,null,null,null,null, $defaultContext)];

        $serializer = new Serializer($normalizers, $encoders);
        $result = $serializer->serialize($users, 'json');

        echo dump($result);
        return $this->render(
            'base.html.twig'
        );
    }
}
