<?php

namespace TriplogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName')
            ->add('lastName')
            ->add('profilePicture')
            ->add('gender')
            ->add('email')
            ->add('password')
            ->add('roles')
            ->add('createdAt');
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
