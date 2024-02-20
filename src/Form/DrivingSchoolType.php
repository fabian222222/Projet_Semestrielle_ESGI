<?php

namespace App\Form;

use App\Entity\DrivingSchool;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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

            ->add('siret', TextType::class, [
                'label' => 'N° de Siret',
                'attr' => [
                    'placeholder' => '3244322348765',
                ],
            ])

            ->add('number', IntegerType::class, [
                'label' => 'N° de voie',
                'attr' => [
                    'placeholder' => '23'
                ]
            ])

            ->add('address', TextType::class, [
                'label' => 'Adresse de  l\'auto-école',
                'attr' => [
                    'placeholder' => '34 Rue des adrien',
                ],
            ])

            ->add('zipCode', IntegerType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => '75013'
                ]
            ])

            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Paris 13'
                ]
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
