<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class JsonUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('json', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => true,
//                'row_attr' => [
//                    'class' => 'btn',
//                ],
            ])
        ->add('import', SubmitType::class);
    }
}
