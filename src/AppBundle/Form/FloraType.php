<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FloraType extends AbstractType
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
                      'plantation_date', TextType::class, array(
                        'label' => 'Fecha de plantación',
                        'required' => false,
                        'attr' => array(
                        'class' => 'form-control mb-lg-3',
                        'placeholder' => ''))
                          )
        ->add('image', FileType::class,array(
            "label" => "Imagen:",
            "attr" =>array("class" => "form-control")
        ))
        ->add(
            'area', null, array(
                'label' => 'Area',
                'required' => true,
                'attr' => array(
                'class' => 'form-control mb-lg-3',
                'placeholder' => 'Seleccione un área...'))
          );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Flora'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_flora';
    }


}
