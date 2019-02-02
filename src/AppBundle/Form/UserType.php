<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
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
            'choice_attr' => function($val, $key, $index) {
              // agrega la clase a cada opción
              return ['class' => 'ml-lg-5'];
            },
            'multiple' => true,
            'expanded'=> true,
            'attr' => array( 'class' => 'mb-lg-3' )
          ]);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
