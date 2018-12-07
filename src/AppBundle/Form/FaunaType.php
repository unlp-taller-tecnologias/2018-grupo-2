<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FaunaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                    'specie',ChoiceType::class, array(
                    'label' => 'Especie',
                    'required' => true,
                    'attr' => array(
                    'class' => 'form-control mb-lg-3',
                    'placeholder' => 'Seleccione una especie...'))
                  )
                  ->add(
                      'subspecie', null, array(
                          'label' => 'Subespecie',
                          'required' => true,
                          'attr' => array(
                          'class' => 'form-control mb-lg-3',
                          'placeholder' => 'Seleccione una subespecie...'))
                    )
                ->add(
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
                        'label' => 'Observaciones',
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'placeholder' => 'Ingrese las observaciones...'))
                    )
                ->add('image', FileType::class,array(
                    "label" => "Imagen:",
                    "attr" =>array("class" => "form-control")
                ))

                ->add(
                    'attendants', null, array(
                        'label' => 'Encargados',
                        'required' => true,
                        'multiple' => true,
                        'attr' => array(
                            'class' => 'form-control mb-lg-3',
                        ),
                        'placeholder' => 'Seleccione un/os encargado/s...')
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
                    'departure_date', DateType::class, array(
                        'label' => 'Fecha de traslado',
                        'required' => true,
                        'widget' => 'single_text',)
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
