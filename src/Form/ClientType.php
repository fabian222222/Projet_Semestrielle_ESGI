<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\DrivingSchool;
use App\Repository\DrivingSchoolRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Benoit',
                ],
            ])

            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Garcia',
                ],
            ])

            ->add('Number', IntegerType::class, [
                'label' => 'N° de voie',
                'attr' => [
                    'placeholder' => '23'
                ]
            ])

            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Rue de paris'
                ]
            ])

            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Paris 13'
                ]
            ])

            ->add('zipCode', IntegerType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => '75013'
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'BenoitGarcia@gmail.com',
                ]
            ])

            ->add('phoneNumber', TextType::class,[
                'label' => 'N° de téléphone',
                'attr'=> [
                    'placeholder' => '061234567890',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
