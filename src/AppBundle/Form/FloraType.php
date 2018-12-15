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
use AppBundle\Entity\FLSpecie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FloraType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                    'specie', EntityType::class, array(
                      'label' => 'Especie',
                      'class' => FLSpecie::class,
                      'choice_label' => 'name',
                      'required' => true,
                      'placeholder' => 'Seleccione una especie...',
                      'attr' => array(
                        'class' => 'form-control mb-lg-3 specie-id'
                      )))
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
                   ->add('image', FileType::class,array(
                          "label" => "Imagen",
                          "attr" =>array("class" => "form-control mb-lg-3")
                      ))
                  ->add(
                      'plantation_date', TextType::class, array(
                        'label' => 'Período de plantación',
                        'required' => false,
                        'attr' => array(
                        'class' => 'form-control col-md-6 mb-lg-3',
                        'placeholder' => ''))
                          )
                    ->add(
                        'area', null, array(
                            'label' => 'Área',
                            'required' => true,
                            'attr' => array(
                            'class' => 'form-control col-md-6 mb-lg-3',
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
