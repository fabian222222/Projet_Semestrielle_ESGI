<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Contract;
use App\Entity\DrivingSchool;
use App\Entity\Product;
use App\Repository\ClientRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $drivingSchool = $options['drivingSchool'];
        $builder
            ->add('client', EntityType::class, [
                    'class' => Client::class,
                    'query_builder' => function (ClientRepository $cr) use($drivingSchool): QueryBuilder  {
                        return $cr->queryFindByDrivingSchool($drivingSchool);
                    },
                    'choice_label' => 'firstname']
            )
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'productName',
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('drivingSchool');
        $resolver->setAllowedTypes('drivingSchool', DrivingSchool::class);
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}
