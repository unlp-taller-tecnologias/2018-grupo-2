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

class FaunaFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                  'destination', TextType::class, array(
                      'label' => 'Próximo destino',
                      'attr' => array(
                          'class' => 'form-control mb-lg-3',
                          'placeholder' => 'Ingrese próximo destino...'))
                  )
                  ->add(
                      'attendants', null, array(
                          'label' => 'Encargados',
                          'multiple' => false,
                          'attr' => array(
                              'class' => 'form-control mb-lg-3',
                          ),
                          'placeholder' => 'Seleccione encargada/o...')
                      )
                  ->add(
                    'specie',ChoiceType::class, array(
                    'label' => 'Especie',
                    'attr' => array(
                        'class' => 'form-control mb-lg-3',
                    ),
                    'placeholder' => 'Seleccione una especie...')
                  )
                  ->add(
                      'subspecie', null, array(
                          'label' => 'Subespecie',
                          'multiple' => false,
                          'attr' => array(
                              'class' => 'form-control mb-lg-3',
                          ),
                          'placeholder' => 'Seleccione una subespecie...')

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
