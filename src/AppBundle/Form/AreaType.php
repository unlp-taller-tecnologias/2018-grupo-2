<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AreaType extends AbstractType
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
                    'polygon', TextType::class, array(
                        'label' => 'Polígono',
                        'attr' => array(
                            'class' => 'form-control mb-lg-3', 
                            'placeholder' => 'Ingrese un polígono...'))
                    );
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Area'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_area';
    }


}
