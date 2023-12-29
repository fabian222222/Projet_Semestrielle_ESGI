<?php

namespace App\Form;

use App\Entity\DrivingSchool;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrivingSchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'auto-école',
                'attr' => [
                    'placeholder' => 'Nom de l\'auto-école',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse de  l\'auto-école',
                'attr' => [
                    'placeholder' => '34 Rue des adrien',
                ],
            ])
            ->add('siret', TextType::class, [
                'label' => 'N° de Siret',
                'attr' => [
                    'placeholder' => '3244322348765',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DrivingSchool::class,
        ]);
    }
}
