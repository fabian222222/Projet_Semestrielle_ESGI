<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\DrivingSchool;
use App\Repository\DrivingSchoolRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
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
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'BenoitGarcia@gmail.com',
                ],
            ])

            ->add('drivingSchool', EntityType::class, [
                'label' => 'Driving',
                'class' => DrivingSchool::class,
                'choice_label' => 'name',
                  /*
                'query_builder' => function (DrivingSchoolRepository $drivingSchoolRepository) {
                    return $drivingSchoolRepository->createQueryBuilder('ds')
                        ->select('ds.name')
                        ->orderBy('ds.name', 'ASC')
                        ->setMaxResults(5);
                },
                  */
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
