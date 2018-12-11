<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Flora;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Flora controller.
 *
 * @Route("flora")
 */
class FloraController extends Controller
{
    /**
     * Lists all flora entities.
     *
     * @Route("/", name="flora_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $floras = $em->getRepository('AppBundle:Flora')->findByPage($request->query->getInt('page', 1),5);

        return $this->render('flora/index.html.twig', array(
            'floras' => $floras,
        ));
    }

    /**
     * Creates a new flora entity.
     *
     * @Route("/new", name="flora_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $flora = new Flora();
        $form = $this->createForm('AppBundle\Form\FloraType', $flora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //subida de imagen
            $file=$form['image']->getData();
            $ext=$file->guessExtension();
            $file_name=time().".".$ext;
            $file->move("uploads", $file_name);
            $flora->setImage($file_name);

            $em->persist($flora);
            $em->flush();

            return $this->redirectToRoute('flora_show', array('id' => $flora->getId()));
        }

        return $this->render('flora/new.html.twig', array(
            'flora' => $flora,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a flora entity.
     *
     * @Route("/{id}", name="flora_show")
     * @Method("GET")
     */
    public function showAction(Flora $flora)
    {
        $deleteForm = $this->createDeleteForm($flora);

        return $this->render('flora/show.html.twig', array(
            'flora' => $flora,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing flora entity.
     *
     * @Route("/{id}/edit", name="flora_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Flora $flora)
    {
        $deleteForm = $this->createDeleteForm($flora);
        $editForm = $this->createForm('AppBundle\Form\FloraType', $flora);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flora_edit', array('id' => $flora->getId()));
        }

        return $this->render('flora/edit.html.twig', array(
            'flora' => $flora,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a flora entity.
     *
     * @Route("/{id}", name="flora_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Flora $flora)
    {
        $form = $this->createDeleteForm($flora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($flora);
            $em->flush();
        }

        return $this->redirectToRoute('flora_index');
    }

    /**
     * Creates a form to delete a flora entity.
     *
     * @param Flora $flora The flora entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Flora $flora)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('flora_delete', array('id' => $flora->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
