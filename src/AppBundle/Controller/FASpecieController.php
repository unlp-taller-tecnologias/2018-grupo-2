<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FASpecie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Faspecie controller.
 *
 * @Route("faspecie")
 */
class FASpecieController extends Controller
{
    /**
     * Lists all fASpecie entities.
     *
     * @Route("/", name="faspecie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fASpecies = $em->getRepository('AppBundle:FASpecie')->findAll();

        return $this->render('faspecie/index.html.twig', array(
            'fASpecies' => $fASpecies,
        ));
    }

    /**
     * Creates a new fASpecie entity.
     *
     * @Route("/new", name="faspecie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fASpecie = new Faspecie();
        $form = $this->createForm('AppBundle\Form\FASpecieType', $fASpecie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fASpecie);
            $em->flush();

            return $this->redirectToRoute('faspecie_index');
        }

        return $this->render('faspecie/new.html.twig', array(
            'fASpecie' => $fASpecie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fASpecie entity.
     *
     * @Route("/{id}/edit", name="faspecie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FASpecie $fASpecie)
    {
        $deleteForm = $this->createDeleteForm($fASpecie);
        $editForm = $this->createForm('AppBundle\Form\FASpecieType', $fASpecie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('faspecie_index');
        }

        return $this->render('faspecie/edit.html.twig', array(
            'fASpecie' => $fASpecie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fASpecie entity.
     *
     * @Route("/{id}", name="faspecie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FASpecie $fASpecie)
    {
        $form = $this->createDeleteForm($fASpecie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fASpecie);
            $em->flush();
        }

        return $this->redirectToRoute('faspecie_index');
    }

    /**
     * Creates a form to delete a fASpecie entity.
     *
     * @param FASpecie $fASpecie The fASpecie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FASpecie $fASpecie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('faspecie_delete', array('id' => $fASpecie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
