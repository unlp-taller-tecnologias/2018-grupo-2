<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attendant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Attendant controller.
 *
 * @Route("attendant")
 */
class AttendantController extends Controller
{
    /**
     * Lists all attendant entities.
     *
     * @Route("/", name="attendant_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $attendants = $em->getRepository('AppBundle:Attendant')->findAll();

        return $this->render('attendant/index.html.twig', array(
            'attendants' => $attendants,
        ));
    }

    /**
     * Creates a new attendant entity.
     *
     * @Route("/new", name="attendant_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $attendant = new Attendant();
        $form = $this->createForm('AppBundle\Form\AttendantType', $attendant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($attendant);
            $em->flush();

            return $this->redirectToRoute('attendant_show', array('id' => $attendant->getId()));
        }

        return $this->render('attendant/new.html.twig', array(
            'attendant' => $attendant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a attendant entity.
     *
     * @Route("/{id}", name="attendant_show")
     * @Method("GET")
     */
    public function showAction(Attendant $attendant)
    {
        $deleteForm = $this->createDeleteForm($attendant);

        return $this->render('attendant/show.html.twig', array(
            'attendant' => $attendant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing attendant entity.
     *
     * @Route("/{id}/edit", name="attendant_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Attendant $attendant)
    {
        $deleteForm = $this->createDeleteForm($attendant);
        $editForm = $this->createForm('AppBundle\Form\AttendantType', $attendant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attendant_edit', array('id' => $attendant->getId()));
        }

        return $this->render('attendant/edit.html.twig', array(
            'attendant' => $attendant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a attendant entity.
     *
     * @Route("/{id}", name="attendant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Attendant $attendant)
    {
        $form = $this->createDeleteForm($attendant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($attendant);
            $em->flush();
        }

        return $this->redirectToRoute('attendant_index');
    }

    /**
     * Creates a form to delete a attendant entity.
     *
     * @param Attendant $attendant The attendant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Attendant $attendant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('attendant_delete', array('id' => $attendant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
