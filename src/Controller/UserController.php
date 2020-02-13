<?php /** @noinspection ALL */

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserFormType;
use App\Form\JsonUserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        // TODO
        //  move form to seprate function
        //import json form
        $form = $this->createForm(JsonUserFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $json = $form->get('json')->getData();
            if($json){
                $json = file_get_contents($json);
                $tmp_users = $this->deserialize($json);

                foreach ($tmp_users as $user){
                    dump($user);
                    if(in_array($user->getUsername(), $users)){
                        //update user
                        // check if it is the same user?
                    } else {
                        $encoded = $encoder->encodePassword($user, $user->getPassword());
                        $user->setPassword($encoded);
                        foreach ($user->getRoles() as $role){
                            dump($role);
                            $user->addRole($em->getRepository(Role::class)->findOneBy(['name' => $role]));
                        }
                        return;
                        $em->persist($user);
                        $em->flush();
//                        $this->createUser($user);

                    }
                }
            }
        }
        return $this->render(
            'admin/user/user.html.twig', [
                'users' => $users,
                'form' => $form->createView(),
            ]
        );
    }
    public function createUser($user, UserPasswordEncoderInterface $encoder){
        $new_user = new User();
        $new_user->setUsername($user->getUsername());
        $new_user->setRoles($user->getRoles());
        $new_user->setEmail($user->getEmail());
        $new_user->setFirstname($user->getFirstname());
        $new_user->setLastname($user->getLastname());
        // set default password?
        $encoded = $encoder->encodePassword($user, 'password');
        $new_user->setRoles($user->getRoles());
        $new_user->setPassword($encoded);
        $em->persist($new_user);
        $em->flush();
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
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES => [
                'id',
                'username',
                'email',
                'firstname',
                'lastname',
                'roles',
                'password',
            ],
        ];
//        $normalizers = [new ObjectNormalizer()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];

        $encoders = [new JsonEncoder()];

        $serializer = new Serializer($normalizers, $encoders);
        $result = $serializer->serialize($users, 'json');

        $response = new Response($result);

//        serve file
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'userexport.json'
        );
        $response->headers->set('Content-Disposition', $disposition);
        return $response;

//        write to filesystem
//        $filesystem = new Filesystem();
//        $filesystem->mkdir('/tmp/bloc');
//        $filesystem->touch('/tmp/bloc/json');
//        $filesystem->dumpFile('/tmp/bloc/json', $result);

//        serve json
//        $response = JsonResponse::fromJsonString($result);
//        $response->headers->set('Content-Type', 'application/json');
//        return $response;

//        return $this->render(
//            '/admin/json.html.twig',
//            ['results' => $result],
//        );
    }
    // deserialize json
    public function deserialize($data){
        dump($data);
        $encoder = [new JsonEncoder()];
        $normalizer = [new ArrayDenormalizer(), new ObjectNormalizer(),];
        $serializer = new Serializer($normalizer, $encoder);
        $users = $serializer->deserialize($data, 'App\Entity\User[]', 'json');
//        $users = $serializer->denormalize($data, User::class);
        dump($users);
        return $users;
    }
}
