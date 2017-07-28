<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TramiteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gastoArancel', NumberType::class, array(
                'required' => false,
                'attr' => array(
                   'min' => 0,
                   'step' => 0.0001,)
            ))
            ->add('impuestosPatente', NumberType::class, array(
                'required' => false,
                'attr' => array(
                   'min' => 0,
                   'step' => 0.0001,)
            ))
            ->add('sellados', NumberType::class, array(
                'required' => false,
                'attr' => array(
                   'min' => 0,
                   'step' => 0.0001,)
            ))
            ->add('honorarios', NumberType::class, array(
                'required' => false,
                'attr' => array(
                   'min' => 0,
                   'step' => 0.0001,)
            ))
            ->add('fecha',DateType::class,array(
                    'widget' => 'single_text',
                    'html5' => true,
                    'attr' => ['class' => 'datepicker'],
                    'format' => 'dd-MM-yyyy',
            ))
            ->add('codigoInternoConcesionaria', null, array(
                'required' => false,
                'label' => 'Codigo Interno de Concesionaria (Opcional)'
            ))
            ->add('concesionaria', EntityType::class, array(
                'class' => 'AppBundle:Concesionaria',
                'choice_label' => 'nombre',
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tramite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tramite';
    }


}
