<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * User controller.
 *
 * @Route("users")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="users_index")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findByPage($request->query->getInt('page', 1),5);

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="users_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        if($this->getUser()->getId() != $user->getId()){
          $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        }
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="users_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        if($this->getUser()->getId() != $user->getId()){
          $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        }
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Perfil modificado con éxito.");
            return $this->redirectToRoute('users_show', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}/delete", name="users_delete")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($this->getUser()->getId() != $user->getId()) {
            $em = $this->getDoctrine()->getManager();
            $user->setEnabled(false);
            $em->persist($user);
            $em->flush();
            $this->addFlash("success", "Usuario eliminado con éxito.");
        } else {
            $this->addFlash("error", "No puedes borrarte a ti mismo.");
        }
        return $this->redirectToRoute('users_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
