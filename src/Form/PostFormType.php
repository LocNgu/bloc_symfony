<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'choice_label' => 'name',
            // renders a checkbox
            'multiple' => false,
            'expanded' => true,
            // ignore reading / writing to object
            'mapped' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('user')
                    ->orderBy('user.username', 'ASC');
            },
            'attr' => ['data' => true],
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'title',
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullname',
            ])
//            ->add('newTag', TextType::class, [
//                'label' => 'tag',
//                'mapped' => false,
//            ])
//            ->add('tags', EntityType::class, [
//                'class' => Tag::class,
//                'choice_label' => 'name',
//                'multiple' => true,
//                'expanded' => true,
//            ])
            ->add('tags', CollectionType::class, [
                'entry_type' => TagFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                // renders a checkbox
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('category')
                        ->orderBy('category.name', 'ASC');
                },
                'attr' => ['data' => true],
            ])
            ->add('publicationDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('public', CheckboxType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
            ])
        ;
    }
}
