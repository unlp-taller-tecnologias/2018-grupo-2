<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FASubspecie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Fasubspecie controller.
 *
 * @Route("fasubspecie")
 */
class FASubspecieController extends Controller
{
    /**
     * Lists all fASubspecie entities.
     *
     * @Route("/", name="fasubspecie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fASubspecies = $em->getRepository('AppBundle:FASubspecie')->findAll();

        return $this->render('fasubspecie/index.html.twig', array(
            'fASubspecies' => $fASubspecies,
        ));
    }

    /**
     * Creates a new fASubspecie entity.
     *
     * @Route("/new", name="fasubspecie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fASubspecie = new Fasubspecie();
        $form = $this->createForm('AppBundle\Form\FASubspecieType', $fASubspecie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fASubspecie);
            $em->flush();

            return $this->redirectToRoute('fasubspecie_index');
        }

        return $this->render('fasubspecie/new.html.twig', array(
            'fASubspecie' => $fASubspecie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fASubspecie entity.
     *
     * @Route("/{id}/edit", name="fasubspecie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FASubspecie $fASubspecie)
    {
        $deleteForm = $this->createDeleteForm($fASubspecie);
        $editForm = $this->createForm('AppBundle\Form\FASubspecieType', $fASubspecie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fasubspecie_index');
        }

        return $this->render('fasubspecie/edit.html.twig', array(
            'fASubspecie' => $fASubspecie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fASubspecie entity.
     *
     * @Route("/{id}", name="fasubspecie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FASubspecie $fASubspecie)
    {
        $form = $this->createDeleteForm($fASubspecie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fASubspecie);
            $em->flush();
        }

        return $this->redirectToRoute('fasubspecie_index');
    }

    /**
     * Creates a form to delete a fASubspecie entity.
     *
     * @param FASubspecie $fASubspecie The fASubspecie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FASubspecie $fASubspecie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fasubspecie_delete', array('id' => $fASubspecie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
