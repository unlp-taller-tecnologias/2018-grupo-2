<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fauna;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Fauna controller.
 *
 * @Route("fauna")
 */
class FaunaController extends Controller
{
    /**
     * Lists all fauna entities.
     *
     * @Route("/", name="fauna_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $faunas = $em->getRepository('AppBundle:Fauna')->findAll();

        return $this->render('fauna/index.html.twig', array(
            'faunas' => $faunas,
        ));
    }

    /**
     * Creates a new fauna entity.
     *
     * @Route("/new", name="fauna_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fauna = new Fauna();
        $form = $this->createForm('AppBundle\Form\FaunaType', $fauna);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //subida de imagen 
            $file=$form['image']->getData();
            $ext=$file->guessExtension();
            $file_name=time().".".$ext;
            $file->move("uploads", $file_name);
            $fauna->setImage($file_name);

            $em->persist($fauna);
            $em->flush();

            return $this->redirectToRoute('fauna_show', array('id' => $fauna->getId()));
        }

        return $this->render('fauna/new.html.twig', array(
            'fauna' => $fauna,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fauna entity.
     *
     * @Route("/{id}", name="fauna_show")
     * @Method("GET")
     */
    public function showAction(Fauna $fauna)
    {
        $deleteForm = $this->createDeleteForm($fauna);

        return $this->render('fauna/show.html.twig', array(
            'fauna' => $fauna,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fauna entity.
     *
     * @Route("/{id}/edit", name="fauna_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fauna $fauna)
    {
        $deleteForm = $this->createDeleteForm($fauna);
        $editForm = $this->createForm('AppBundle\Form\FaunaType', $fauna);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fauna_edit', array('id' => $fauna->getId()));
        }

        return $this->render('fauna/edit.html.twig', array(
            'fauna' => $fauna,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fauna entity.
     *
     * @Route("/{id}", name="fauna_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fauna $fauna)
    {
        $form = $this->createDeleteForm($fauna);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fauna);
            $em->flush();
        }

        return $this->redirectToRoute('fauna_index');
    }

    /**
     * Creates a form to delete a fauna entity.
     *
     * @param Fauna $fauna The fauna entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fauna $fauna)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fauna_delete', array('id' => $fauna->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
