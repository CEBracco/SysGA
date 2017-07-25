<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MovimientoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('monto')
                ->add('fecha',DateType::class,array(
                        'widget' => 'single_text',
                        'html5' => true,
                        'attr' => ['class' => 'datepicker'],
                        'format' => 'dd-MM-yyyy',
                ))
                ->add('tipo', ChoiceType::class, array(
                        'choices' => array(
                            'Entrada' => 'Entrada',
                            'Salida' => 'Salida',
                            'Deposito en registro' => 'Deposito en registro',
                        )
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
            'data_class' => 'AppBundle\Entity\Movimiento'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_movimiento';
    }


}
