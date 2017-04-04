<?php

namespace TriplogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tripName')
            ->add('tripDesc')
            ->add('isPublic')
            ->add('createdAt', DateTimeType::class,[
                'data' => new \DateTime('now'),
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd  HH:mm',
                'attr' => [
                    'class' => 'js-datetimepicker'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'TriplogBundle\Entity\Trip'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'triplog_bundle_trip_form_type';
    }
}
