<?php

namespace Neralind\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
          ->add('email', 'email', array('label' => false, 'translation_domain' => 'FOSUserBundle', 'placeholder' => 'form.email'))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;

        $builder->add('username', 'text', array('label'=> false, 'attr' => array('placeholder' => '')));
    }

    public function getName()
    {
        return 'acme_user_registration';
    }
}