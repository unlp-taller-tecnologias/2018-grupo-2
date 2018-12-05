<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FASubspecieType extends AbstractType
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
                    'specie', null, array(
                        'label' => 'Especie', 
                        'required' => true,
                        'attr' => array(
                            'class' => 'form-control mb-lg-3'
                        ),
                        'placeholder' => 'Seleccione una especie...')
                    );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FASubspecie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_fasubspecie';
    }


}
