<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('roles', CollectionType::class, [
            'entry_type' => TextType::class,

            ])
            ->add('save', SubmitType::class)
            ;
    }
}
