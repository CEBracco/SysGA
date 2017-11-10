<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TareaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('fecha',DateType::class,array(
					'widget' => 'single_text',
					'html5' => true,
					'format' => 'dd/MM/yyyy',
			))
			->add('titulo')
			->add('descripcion')
			->add('user', EntityType::class, array(
				'class' => 'AppBundle:User',
				'query_builder' => function (EntityRepository $er) {
					return $er->createQueryBuilder('u')
							->where('u.roles like :role')
							->orWhere('u.roles like :role2')
							->setParameter('role', '%ROLE_GESTION%')
							->setParameter('role2', '%ROLE_ADMIN%')
							->orderBy('u.username', 'ASC');
				},
				'choice_label' => function ($user) {
					return $user->toString();
				},
			));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tarea'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tarea';
    }


}
