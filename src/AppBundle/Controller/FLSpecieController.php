<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FLSpecie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Flspecie controller.
 *
 * @Route("flspecie")
 */
class FLSpecieController extends Controller
{
    /**
     * Lists all fLSpecie entities.
     *
     * @Route("/", name="flspecie_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $fLSpecies = $em->getRepository('AppBundle:FLSpecie')->findByPage($request->query->getInt('page', 1),5);

        return $this->render('flspecie/index.html.twig', array(
            'fLSpecies' => $fLSpecies,
        ));
    }

    /**
     * Creates a new fLSpecie entity.
     *
     * @Route("/new", name="flspecie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fLSpecie = new Flspecie();
        $form = $this->createForm('AppBundle\Form\FLSpecieType', $fLSpecie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fLSpecie);
            $em->flush();

            return $this->redirectToRoute('flspecie_index');
        }

        return $this->render('flspecie/new.html.twig', array(
            'fLSpecie' => $fLSpecie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fLSpecie entity.
     *
     * @Route("/{id}/edit", name="flspecie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FLSpecie $fLSpecie)
    {
        $deleteForm = $this->createDeleteForm($fLSpecie);
        $editForm = $this->createForm('AppBundle\Form\FLSpecieType', $fLSpecie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flspecie_index');
        }

        return $this->render('flspecie/edit.html.twig', array(
            'fLSpecie' => $fLSpecie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fLSpecie entity.
     *
     * @Route("/{id}", name="flspecie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FLSpecie $fLSpecie)
    {
        $form = $this->createDeleteForm($fLSpecie);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $fLSpecie->setDeleted(true);
            $em->persist($fLSpecie);
            $em->flush();

        return $this->redirectToRoute('flspecie_index');
    }

    /**
     * Creates a form to delete a fLSpecie entity.
     *
     * @param FLSpecie $fLSpecie The fLSpecie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FLSpecie $fLSpecie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('flspecie_delete', array('id' => $fLSpecie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all flspecie listJsonFlspecie.
     *
     * @Route("/list/listJsonFlspecie", name="listJsonFlspecie")
     * @Method("GET")
     */
    public function listJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $FLSpecies = $em->getRepository('AppBundle:FLSpecie')->findAll();
        $rawResponse = ['rows'];
          foreach($FLSpecies as $FLSpecie) {
            $rawResponse['rows'][] = array(
              'id' => $FLSpecie->getId(),
              'name' => $FLSpecie->getName(),
            );
          };
      return new JsonResponse($rawResponse['rows']);
    }
}
