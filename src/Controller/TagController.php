<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use App\Form\TagFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    public function create(Request $request, ValidatorInterface $validator)
    {
        $tag = new Tag();

        $form = $this->createForm(TagFormType::class, $tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $em = $this->getDoctrine()->getManager();

            if ($em->getRepository(Tag::class)->findOneBy(['name' => $tag->getName()])) {
            }

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

    public function serialize()
    {
        $tags = $this->getDoctrine()->getManager()->getRepository(Tag::class)->findAll();

        $encoders = [new JsonEncoder()];

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object, $format, $context){
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES => [
                'id',
                'name',
                'posts' => ['id']
            ]
        ];
        $normalizers = [new ObjectNormalizer(null, null,null,null,null,null, $defaultContext)];

        $serializer = new Serializer($normalizers, $encoders);
        $result = dump($serializer->serialize($tags, 'json'));

        echo $result;
        return $this->render(
            'base.html.twig'
        );
    }
}
