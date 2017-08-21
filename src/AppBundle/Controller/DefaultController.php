<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/home", name="homepage")
     */
    public function homeAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

	/**
	 * @Route("/account", name="concesionaria_micuenta")
	 * @Method({"GET", "POST"})
	 */
	public function concesionariaCuentaAction(Request $request)
	{
		if($this->getUser()->getRol() == 'ROLE_CONCESIONARIA'){
			return $this->render('concesionaria/cuenta.html.twig',array(
				'concesionaria' => $this->getUser()->getConcesionaria(),
			));
		}
		else{
			return $this->redirectToRoute('index');
		}
	}
}
