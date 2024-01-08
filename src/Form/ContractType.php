<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Contract;
use App\Repository\CategoryRepository;
use App\Repository\ClientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('price', IntegerType::class)
            ->add('description', TextareaType::class)
            ->add('validityDate', DateTimeType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('client', EntityType::class, [
                'label' => 'Choissisez votre client ',
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
            'data_class' => Contract::class,
        ]);
    }
}
