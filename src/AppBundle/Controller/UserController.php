<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Route("usuario")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
     public function indexAction()
     {
         $em = $this->getDoctrine()->getManager();

         $users = $em->getRepository('AppBundle:User')->findAll();

         return $this->render('usuario/index.html.twig', array(
             'usuarios' => $users,
         ));
     }

     /**
      * Deletes a user entity.
      *
      * @Route("/{id}/delete", name="user_delete")
      * @Method("GET")
      */
     public function deleteAction(Request $request, User $user)
     {
         $em = $this->getDoctrine()->getManager();
         $em->remove($user);
         $em->flush();

         return $this->redirectToRoute('user_index');
     }
}
