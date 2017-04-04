<?php

namespace TriplogBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripLocationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trip', EntityType::class, [
                'class' => 'TriplogBundle:Trip',
                'placeholder' => 'Select trip',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('trip')
                        ->orderBy('trip.createdAt', 'DESC');
                },
            ])
            ->add('tripCategory', EntityType::class,[
                'class' => 'TriplogBundle:TripCategory',
                'placeholder' => 'Select category',
                'query_builder' => function(EntityRepository  $repository) {
                    return $repository->createQueryBuilder('category')
                        ->orderBy('category.tripCatName', 'ASC');
                }
            ])
            ->add('tripLocName')
            ->add('tripLocDesc')
            ->add('tripLatLon')
            ->add('isPublic')
            ->add('createdAt', DateTimeType::class,[
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datetimepicker'
                ],
                'html5' => false,
            ]);
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
