<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FLSubspecie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Flsubspecie controller.
 *
 * @Route("flsubspecie")
 */
class FLSubspecieController extends Controller
{
    /**
     * Lists all fLSubspecie entities.
     *
     * @Route("/", name="flsubspecie_index")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $all = $request->query->all();
        $em = $this->getDoctrine()->getManager();
        $arrayParams = array('name' => isset($all["name"])? $all["name"]:NULL);
        $fLSubspecies = $em->getRepository('AppBundle:FLSubspecie')->findByPage($request->query->getInt('page', 1),$this->container->getParameter('pagination'),$arrayParams);
        return $this->render('flsubspecie/index.html.twig', array(
            'fLSubspecies' => $fLSubspecies,
            'params' =>$arrayParams,
        ));
    }

    /**
     * Creates a new fLSubspecie entity.
     *
     * @Route("/new", name="flsubspecie_new")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fLSubspecie = new Flsubspecie();
        $form = $this->createForm('AppBundle\Form\FLSubspecieType', $fLSubspecie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fLSubspecie);
            $em->flush();
            $this->addFlash("success", "Subespecie creada con éxito.");
            return $this->redirectToRoute('flsubspecie_index');
        }

        return $this->render('flsubspecie/new.html.twig', array(
            'fLSubspecie' => $fLSubspecie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fLSubspecie entity.
     *
     * @Route("/{id}/edit", name="flsubspecie_edit")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FLSubspecie $fLSubspecie)
    {
        $deleteForm = $this->createDeleteForm($fLSubspecie);
        $editForm = $this->createForm('AppBundle\Form\FLSubspecieType', $fLSubspecie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Subespecie editada con éxito.");
            return $this->redirectToRoute('flsubspecie_index');
        }

        return $this->render('flsubspecie/edit.html.twig', array(
            'fLSubspecie' => $fLSubspecie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fLSubspecie entity.
     *
     * @Route("/{id}", name="flsubspecie_delete")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FLSubspecie $fLSubspecie)
    {
        $form = $this->createDeleteForm($fLSubspecie);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if(empty($em->getRepository('AppBundle:Flora')->findOneBy(array('deleted'=>false,'subspecie'=>$fLSubspecie->getId())))){
              $fLSubspecie->setDeleted(true);
              $at='@';
              while(!is_null($em->getRepository('AppBundle:FLSubspecie')->findOneBy(array('name'=>$at.$fLSubspecie->getname())))){
                $at=$at.'@';
              }
              $fLSubspecie->setName($at.$fLSubspecie->getName());
              $em->persist($fLSubspecie);
              $em->flush();
            }
            else {
              $this->addFlash("error", "No se pudo eliminar debido a que existen individuos pertenecientes a esa subespecie.");
              return $this->redirectToRoute('flsubspecie_index');
            }

        $this->addFlash("success", "Subespecie eliminada con éxito.");
        return $this->redirectToRoute('flsubspecie_index');
    }

    /**
     * Creates a form to delete a fLSubspecie entity.
     *
     * @param FLSubspecie $fLSubspecie The fLSubspecie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FLSubspecie $fLSubspecie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('flsubspecie_delete', array('id' => $fLSubspecie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all flsubspecie.
     *
     * @Route("/list/listJsonFlsubspecie", name="listJsonFlsubspecie")
     * @Method("GET")
     */
    public function listJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $flsubspecies = $em->getRepository('AppBundle:FLSubspecie')->findBy(array('deleted' => false ));
        $rawResponse = ['rows'];
          foreach($flsubspecies as $flsubspecie) {
              $rawResponse['rows'][] = array(
                'id' => $flsubspecie->getId(),
                'idSpecie' => $flsubspecie->getFLSpecie()->getId(),
                'name' => $flsubspecie->getName(),
              );
          };
      return new JsonResponse($rawResponse['rows']);
    }
}
