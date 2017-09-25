<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TramiteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tramite=$builder->getData();

        $builder
            ->add('gastoArancel', NumberType::class, array(
                'required' => true,
                'attr' => array(
                   'min' => 0,)
            ))
            ->add('impuestosPatente', NumberType::class, array(
                'required' => true,
                'attr' => array(
                   'min' => 0,)
            ))
            ->add('selladosGestoria', NumberType::class, array(
                'required' => true,
                'attr' => array(
                   'min' => 0,)
            ))
            ->add('selladosRegistro', NumberType::class, array(
                'required' => true,
                'attr' => array(
                   'min' => 0,)
            ))
            ->add('honorarios', NumberType::class, array(
                'required' => true,
                'attr' => array(
                   'min' => 0,)
            ))
            ->add('otros', NumberType::class, array(
                'required' => true,
                'attr' => array(
                   'min' => 0,)
            ))
            ->add('fecha',DateType::class,array(
                    'widget' => 'single_text',
                    'html5' => true,
                    'format' => 'dd/MM/yyyy',
            ))
            ->add('codigoInternoConcesionaria', null, array(
                'required' => false,
                'label' => 'Codigo Interno de Concesionaria (Opcional)'
            ))
            ->add('concesionaria', EntityType::class, array(
                'class' => 'AppBundle:Concesionaria',
                'choice_label' => 'nombre',
            ))
            ->add('registroDelAutomotor', EntityType::class, array(
                'class' => 'AppBundle:RegistroDelAutomotor',
                'choice_label' => 'nombre',
            ))
			->add('otros', NumberType::class, array(
				'required' => false,
				'attr' => array(
				   'min' => 0,)
			))
			->add('gastosAdicionalesNuevos', HiddenType::class, array(
				'mapped' => false,
			))
			->add('depositoEnRegistro', NumberType::class, array(
				'required' => false,
				'mapped' => false,
				'attr' => array(
				   'min' => 0,)
			));
			// ->add('depositoGestoria', NumberType::class, array(
			// 	'required' => false,
			// 	'mapped' => false,
			// 	'attr' => array(
			// 	   'min' => 0,)
			// ));

        if($tramite->getTitular() == null){
            $builder
				->add('dniTitular', IntegerType::class, array(
					'required' => true,
					'mapped' => false,
					'label'  => 'DNI titular',
					'attr' => array(
					   'min' => 0)
				))
                ->add('nombreTitular', null, array(
                    'required' => true,
                    'mapped' => false
                ))
                ->add('apellidoTitular', null, array(
                    'required' => true,
                    'mapped' => false
                ))
                ->add('provinciaTitular', EntityType::class, array(
                    'class' => 'AppBundle:Provincia',
                    'choice_label' => 'nombre',
                    'mapped' => false
                ));
        }
        else{
            $titular=$tramite->getTitular();
            $builder
				->add('dniTitular', IntegerType::class, array(
					'required' => true,
					'mapped' => false,
					'label'  => 'DNI titular',
					'data' => $titular->getDni(),
					'attr' => array(
					   'min' => 0)
				))
                ->add('nombreTitular', null, array(
                    'required' => true,
                    'mapped' => false,
                    'data' => $titular->getNombre(),
                ))
                ->add('apellidoTitular', null, array(
                    'required' => true,
                    'mapped' => false,
                    'data' => $titular->getApellido(),
                ))
                ->add('provinciaTitular', EntityType::class, array(
                    'class' => 'AppBundle:Provincia',
                    'choice_label' => 'nombre',
                    'mapped' => false,
                    'data' => $titular->getProvincia(),
                ));
        }
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
