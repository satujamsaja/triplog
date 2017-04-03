<?php

namespace TriplogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripLocationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trip')
            ->add('tripCategory')
            ->add('tripLocName')
            ->add('tripLocDesc')
            ->add('tripLatLon')
            ->add('isPublic')
            ->add('createdAt');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'TriplogBundle\Entity\TripLocation'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'triplog_bundle_trip_location_form_type';
    }
}
