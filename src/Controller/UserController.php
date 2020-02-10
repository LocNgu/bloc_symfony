<?php /** @noinspection ALL */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

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

        // handling circular reference on roles
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
                'roles' => ['id'],
            ],
        ];

        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];

        $encoders = [new JsonEncoder()];

        $serializer = new Serializer($normalizers, $encoders);
        $result = $serializer->serialize($users, 'json');
        return $this->render(
            '/admin/json.html.twig',
            ['result' => $result],
        );
    }
    // test deserializer
    public function deserialize(){
        $data = '[{
            "username": "Jason",
            "email": "jason@json.com",
            "firstname": "jason",
            "lastname": "json"
        }, {
            "username": "Jason2",
            "email": "jason@json.com",
            "firstname": "jason",
            "lastname": "json"
        }]';
        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer(), new ArrayDenormalizer()];

        $serializer = new Serializer($normalizer, $encoder);
        $users = $serializer->deserialize($data, 'App\Entity\User[]', 'json');
        dump($users);
        return $this->render(
            '/admin/json.html.twig',
            ['results' => $users],
            );
    }
}
