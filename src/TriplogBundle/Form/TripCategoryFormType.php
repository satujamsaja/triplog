<?php

namespace TriplogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripCategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tripCatName')
            ->add('createdAt', DateTimeType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datetimepicker',
                ],
                'html5' => false,
                'format' => 'MM/dd/y h:m a'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'TriplogBundle\Entity\TripCategory'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'triplog_bundle_trip_category_form_type';
    }
}
