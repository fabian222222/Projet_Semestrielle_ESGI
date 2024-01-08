<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\DrivingSchool;
use App\Entity\Invoice;
use App\Repository\ClientRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $drivingSchool = $options['drivingSchool'];
        $builder
            ->add('name')
            ->add('description')
            ->add('date', DateTimeType::class,[
                'label' => 'Date de création de la facture',
                'disabled' => true,
                'mapped' => false
            ])
            ->add('typePayment')
            ->add('price')
            ->add('client', EntityType::class, [
                    'class' => Client::class,
                    'query_builder' => function (ClientRepository $cr) use($drivingSchool): QueryBuilder  {
                        return $cr->queryFindByDrivingSchool($drivingSchool);
                    },
                    'choice_label' => 'name']
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('drivingSchool');
        $resolver->setAllowedTypes('drivingSchool', DrivingSchool::class);
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
