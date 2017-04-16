<?php

namespace TriplogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName')
            ->add('lastName')
            ->add('profilePicture')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'male' => 'Male',
                    'female' => 'Female'
                ],
                'placeholder' => 'Select gender'
            ])
            ->add('email')
            ->add('password')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_ADMIN' => 'Admin'
                ],
                'placeholder' => 'Select role'
            ])
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
            'data_class' => 'TriplogBundle\Entity\User'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'triplog_bundle_user_form_type';
    }
}
