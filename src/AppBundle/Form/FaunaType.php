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
use AppBundle\Entity\FASpecie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class FaunaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                      'specie',EntityType::class, array(
                        'label' => 'Especie',
                        'class' => FASpecie::class,
                        'query_builder' => function (EntityRepository $er) {
                          return $er->createQueryBuilder('f')
                          ->andWhere('f.deleted = :deleted')
                          ->setParameter('deleted', false)
                          ->orderBy('f.name', 'ASC');
                        },
                        'choice_label' => 'name',
                        'required' => true,
                        'placeholder' => 'Seleccione una especie...',
                        'attr' => array(
                          'class' => 'form-control mb-lg-3 specie-id'
                        )
                      )
                    )
                  ->add(
                        'subspecie', null, array(
                          'label' => 'Subespecie',
                          'required' => true,
                          'placeholder' => 'Seleccione una subespecie...',
                          'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'disabled' => true,
                          )
                        )
                      )
                ->add(
                      'name', TextType::class, array(
                        'label' => 'Nombre',
                        'required' => true,
                        'attr' => array(
                          'class' => 'form-control mb-lg-3',
                          'placeholder' => 'Ingrese un nombre...'
                        )
                      )
                    )
                ->add(
                      'weight', NumberType::class, array(
                          'label' => 'Peso (medido en kilos)',
                          'required' => true,
                          'attr' => array(
                            'class' => 'form-control mb-lg-3',
                            'placeholder' => 'Ingrese un peso...'
                          )
                        )
                      )
                ->add(
                      'image', FileType::class,array(
                        'label' => 'Imagen',
                        'required' => false,
                        'attr' =>array(
                          'class' => 'form-control mb-lg-3'
                        ),
                        'data_class' => null
                      )
                    )
                ->add(
                      'attendants', null, array(
                        'label' => 'Encargados',
                        'required' => true,
                        'multiple' => true,
                        'attr' => array(
                          'class' => 'form-control select2',
                          'id' => 'attendants',
                          'placeholder' => 'Seleccione un encargado/s...'
                        )
                      )
                    )
                ->add(
                      'destination', TextType::class, array(
                        'label' => 'Próximo destino',
                        'required' => false,
                        'attr' => array(
                          'class' => 'form-control mb-lg-3',
                          'placeholder' => 'Ingrese próximo destino...'
                        )
                      )
                    )
                ->add(
                      'departure_date', DateType::class, array(
                        'label' => 'Fecha de traslado',
                        'required' => false,
                        'widget' => 'single_text',
                        'attr' => array(
                          'class' => 'form-control mb-lg-3'
                        )
                      )
                    )
                ->add(
                      'healthObservations', TextareaType::class, array(
                        'label' => 'Observaciones',
                        'required' => false,
                        'attr' => array(
                          'class' => 'form-control mb-lg-3',
                          'placeholder' => 'Ingrese las observaciones...'
                        )
                      )
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
