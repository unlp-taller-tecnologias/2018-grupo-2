<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Category;

class AttendantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                    'name', TextType::class, array(
                        'label' => 'Nombre',
                        'required' => true,
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'placeholder' => 'Ingrese un nombre...'))
                    )
                ->add(
                    'lastName', TextType::class, array(
                        'label' => 'Apellido',
                        'required' => true,
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'placeholder' => 'Ingrese un apellido...'))
                    )
                    ->add(
                        'docNum', IntegerType::class, array(
                            'label' => 'Número de documento',
                            'required' => true,
                            'attr' => array(
                                'class' => 'form-control mb-lg-3',
                                'placeholder' => 'Ingrese un número de documento...'))
                        )
                ->add(
                    'email', EmailType::class, array(
                        'label' => 'Email',
                        'required' => true,
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'placeholder' => 'Ingrese un email...'))
                    )
                ->add(
                    'category', EntityType::class, array(
                        'label' => 'Categoría',
                        'required' => true,
                        'attr' => array(
                            'class' => 'form-control mb-lg-3'
                        ),
                        'class' => Category::class,
                        'placeholder' => 'Seleccione una categoría...'
                    )
                );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Attendant'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_attendant';
    }


}
