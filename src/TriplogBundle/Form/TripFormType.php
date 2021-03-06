<?php

namespace TriplogBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('user', EntityType::class, [
                'class' => 'TriplogBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('user')
                        ->orderBy('user.id', 'ASC');
                },
                'choice_label' => 'username',
                'placeholder' => 'Select user'
            ])
            ->add('tripDesc')
            ->add('isPublic')
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
            'data_class' => 'TriplogBundle\Entity\Trip'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'triplog_bundle_trip_form_type';
    }
}
