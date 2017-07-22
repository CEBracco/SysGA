<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;

class TramiteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gastoArancel',null,array(
                    'required'   => false
            ))
            ->add('impuestosPatente',null,array(
                    'required'   => false
            ))
            ->add('sellados',null,array(
                    'required'   => false
            ))
            ->add('honorarios',null,array(
                    'required'   => false
            ))
            ->add('fecha',DateType::class,array(
                    'widget' => 'single_text',
                    'html5' => true,
                    'attr' => ['class' => 'datepicker'],
                    'format' => 'dd-MM-yyyy',
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
