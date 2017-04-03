<?php

namespace TriplogBundle\Form;

use Symfony\Component\Form\AbstractType;
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
            ->add('createdAt');
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
