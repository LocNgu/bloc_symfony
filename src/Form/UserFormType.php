<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class, [
                'label' => 'id',
                'disabled' => true,
            ])
            ->add('username', TextType::class, [
                'label' => 'username',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'firstname',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'lastname',
            ])
            ->add('email', EmailType::class, [
                'label' => 'email',
            ])
            ->add('roles', EntityType::class, [
                // looks for choices from this entity
                'class' => Role::class,
                // uses the role.name property as the visible option string
                'choice_label' => 'name',
                // renders a checkbox
                'multiple' => true,
                'expanded' => true,
                // ignore reading / writing to object
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('role')
                        ->orderBy('role.name', 'ASC');
                },
                'attr' => ['data' => true],
            ])
            ->add('save', SubmitType::class)
            ;
    }
}
