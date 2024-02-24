<?php

namespace App\Form;

use App\Model\DateData;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = new DateTime();
        $builder
            ->add('date', ChoiceType::class, [
                'attr' => [
                    'placeholder' => 'Choississez une date'
                ],
                'choices' => [
                    '1mois' => DateTime::createFromInterface($now->modify('-1 month')),
                    '3mois' => DateTime::createFromInterface($now->modify('-2 month')),
                    '6mois' => DateTime::createFromInterface($now->modify('-3 month')),
                    '1ans' => DateTime::createFromInterface($now->modify('-6 month')),
                ],
                'empty_data' => '',
                'multiple' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DateData::class,
        ]);
    }
}