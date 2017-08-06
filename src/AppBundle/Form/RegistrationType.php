<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class RegistrationType extends AbstractType{

    public function getParent(){
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix(){
        return 'app_user_registration';
    }

    public function getName(){
        return 'app_user_registration';
    }


	private function roleChoices(){
		$choices = array(
			'Concesionaria' => "ROLE_CONCESIONARIA",
            'Gestión de tramites' => "ROLE_GESTION",
			'Administrador' => "ROLE_ADMIN");
		return $choices;
	}

    public function buildForm(FormBuilderInterface $builder, array $options){
		$choices = $this->roleChoices();
        $builder
			->add('rol', ChoiceType::class, array(
				'label' => 'Rol',
				'choices' => $choices))

			->add('nombre', TextType::class, array(
				'label' => 'Nombre',
				'attr' => array(
					'placeholder' => "Ingresa su nombre...")))

			->add('apellido', TextType::class, array(
				'label' => 'Apellido',
				'attr' => array(
					'placeholder' => "Ingresa su apellido...")))

            ->add('username', IntegerType::class, array(
				'label' => 'DNI',
				'translation_domain' => 'FOSUserBundle',
				'attr' => array(
					'placeholder' => "Ingrese su DNI...")))

			->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
				'label' => 'Email (Opcional)',
				'translation_domain' => 'FOSUserBundle',
				'required' => false,
				'attr' => array(
					'placeholder' => "Ingrese el email...")))

			->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
				'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
				'options' => array(
					'translation_domain' => 'FOSUserBundle'),
				'first_options' => array(
					'label' => 'Contraseña',
					'attr' => array(
						'placeholder' => "Ingrese una contraseña...")),
				'second_options' => array(
					'label' => 'Confirmar contraseña',
					'attr' => array(
						'placeholder' => "Reescriba la contraseña...")),
				'invalid_message' => 'La repetición de la contraseña no coincide'));
    }
}
