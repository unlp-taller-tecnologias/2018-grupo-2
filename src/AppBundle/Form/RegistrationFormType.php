<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle','attr' => array(
                  'class' => 'form-control mb-lg-3',
                  'placeholder' => 'Direccion e-mail')))
          ->add('name', null, array('label' => 'Nombre', 'translation_domain' => 'FOSUserBundle','attr' => array(
                          'class' => 'form-control mb-lg-3',
                          'placeholder' => 'Nombre')))
          ->add('lastname', null, array('label' => 'Apellido', 'translation_domain' => 'FOSUserBundle','attr' => array(
                                  'class' => 'form-control mb-lg-3',
                                  'placeholder' => 'Apellido')))
          ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle','attr' => array(
                  'class' => 'form-control mb-lg-3',
                  'placeholder' => 'Nombre de Usuario')))
          ->add('roles', ChoiceType::class, [
            'choices' => [
                'Administrador' => 'ROLE_ADMIN',
                'Data entry' => 'ROLE_DATA_ENTRY',
                'Responsable de informes' => 'ROLE_REPORTS'
            ],
            'multiple' => true,
            'expanded'=> true,
            'attr' => array( 'class' => 'mb-lg-3' )
          ])
          ->add('plainPassword', RepeatedType::class, array(
              'type' => PasswordType::class,
              'options' => array(
                  'translation_domain' => 'FOSUserBundle',
                  'attr' => array(
                      'autocomplete' => 'new-password',
                      'class' => 'form-control mb-lg-3',
                      'placeholder' => 'Contraseña'
                  ),
              ),
              'first_options' => array('label' => 'form.password'),
              'second_options' => array('label' => 'form.password_confirmation'),
              'invalid_message' => 'fos_user.password.mismatch',
          ));
    }

    public function getParent()
    {
        return BaseRegistrationFormType::class;

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
