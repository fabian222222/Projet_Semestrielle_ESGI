<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\DrivingSchool;
use App\Entity\Invoice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('date')
            ->add('typePayment')
            ->add('price')
            ->add('drivingSchool', EntityType::class, [
                'label' => 'Test 2',
                'class' => DrivingSchool::class,
                'choice_label' => 'name',
            ])
            ->add('client', EntityType::class, [
                'label' => 'Test 2',
                'class' => Client::class,
                'choice_label' => 'name',
                //'query_builder' => function (ClientRepository $clientRepository) use ($options) {
                //return $clientRepository->findByDrivingSchoolid($options['idS']);

                //   },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
