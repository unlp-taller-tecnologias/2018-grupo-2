<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Area;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Area controller.
 *
 * @Route("area")
 */
class AreaController extends Controller
{
    /**
     * Lists all area entities.
     *
     * @Route("/", name="area_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $areas = $em->getRepository('AppBundle:Area')->findByPage($request->query->getInt('page', 1),5);

        return $this->render('area/index.html.twig', array(
            'areas' => $areas,
        ));
    }

    /**
     * Creates a new area entity.
     *
     * @Route("/new", name="area_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $area = new Area();
        $form = $this->createForm('AppBundle\Form\AreaType', $area);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($area);
            $em->flush();

            return $this->redirectToRoute('area_index');
        }

        return $this->render('area/new.html.twig', array(
            'area' => $area,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing area entity.
     *
     * @Route("/{id}/edit", name="area_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Area $area)
    {
        $deleteForm = $this->createDeleteForm($area);
        $editForm = $this->createForm('AppBundle\Form\AreaType', $area);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('area_index');
        }

        return $this->render('area/edit.html.twig', array(
            'area' => $area,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a area entity.
     *
     * @Route("/{id}", name="area_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Area $area)
    {
        $form = $this->createDeleteForm($area);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $area->setDeleted(true);
            $em->persist($area);
            $em->flush();
        }

        return $this->redirectToRoute('area_index');
    }

    /**
     * Creates a form to delete a area entity.
     *
     * @param Area $area The area entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Area $area)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('area_delete', array('id' => $area->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all listJsonArea.
     *
     * @Route("/list/listJsonArea", name="listJsonArea")
     * @Method("GET")
     */
    public function listJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Areas = $em->getRepository('AppBundle:Area')->findAll();
        $rawResponse = ['rows'];
          foreach($Areas as $Area) {
            $rawResponse['rows'][] = array(
              'id' => $Area->getId(),
              'name' => $Area->getName(),
            );
          };
      return new JsonResponse($rawResponse['rows']);
    }
}
