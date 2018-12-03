<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FaunaType extends AbstractType
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
                    'weight', TextType::class, array(
                        'label' => 'Peso', 
                        'required' => true,
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'placeholder' => 'Ingrese un peso...'))
                    )
                ->add(
                    'healthObservations', TextareaType::class, array(
                        'label' => 'Observación',
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'placeholder' => 'Ingrese una observación...'))
                    )
                ->add(
                    'image', null, array(
                        'label' => 'Imagen',
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'placeholder' => 'Seleccione una imagen...'))
                    )
                ->add(
                    'attendants', null, array(
                        'label' => 'Encargados', 
                        'required' => true,
                        'multiple' => true,
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'id' => 'attendants'
                        ),
                        'placeholder' => 'Seleccione un encargado...')
                    )
                ->add(
                    'destination', TextType::class, array(
                        'label' => 'Próximo destino', 
                        'required' => true,
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'placeholder' => 'Ingrese próximo destino...'))
                    )
                ->add(
                    'subspecie', null, array(
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
            'data_class' => 'AppBundle\Entity\Fauna'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_fauna';
    }


}
