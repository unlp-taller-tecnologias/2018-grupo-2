<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FASubspecie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $fASubspecies = $em->getRepository('AppBundle:FASubspecie')->findByPage($request->query->getInt('page', 1),5);

        return $this->render('fasubspecie/index.html.twig', array(
            'fASubspecies' => $fASubspecies,
        ));
    }

    /**
     * Creates a new fASubspecie entity.
     *
     * @Route("/new", name="fasubspecie_new")
     * @Security("is_granted('ROLE_ADMIN')")
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
            $this->addFlash("success", "Subespecie creada con éxito.");
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
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FASubspecie $fASubspecie)
    {
        $deleteForm = $this->createDeleteForm($fASubspecie);
        $editForm = $this->createForm('AppBundle\Form\FASubspecieType', $fASubspecie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Subespecie editada con éxito.");
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
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FASubspecie $fASubspecie)
    {
        $form = $this->createDeleteForm($fASubspecie);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if(empty($em->getRepository('AppBundle:Fauna')->findOneBy(array('deleted'=>false,'subspecie'=>$fASubspecie->getId())))){
              $fASubspecie->setDeleted(true);
              $at='@';
              while(!is_null($em->getRepository('AppBundle:FASubspecie')->findOneBy(array('name'=>$at.$fASubspecie->getname())))){
                $at=$at.'@';
              }
              $fASubspecie->setName($at.$fASubspecie->getName());
              $em->persist($fASubspecie);
              $em->flush();
          }
          else {
            $this->addFlash("error", "No se pudo eliminar debido a que existen individuos pertenecientes a esa subespecie.");
            return $this->redirectToRoute('fasubspecie_index');
          }

        $this->addFlash("success", "Subespecie eliminada con éxito.");
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

    /**
     * Lists all attendant fasubspecie.
     *
     * @Route("/list/listJsonFasubspecie", name="listJsonFasubspecie")
     * @Method("GET")
     */
    public function listJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fasubspecies = $em->getRepository('AppBundle:FASubspecie')->findAll();
        $rawResponse = ['rows'];
          foreach($fasubspecies as $fasubspecie) {
            if ($fasubspecie->getDeleted() != true) {
              $rawResponse['rows'][] = array(
                'id' => $fasubspecie->getId(),
                'idSpecie' => $fasubspecie->getFASpecie()->getId(),
                'name' => $fasubspecie->getName(),
              );
            }
          };
      return new JsonResponse($rawResponse['rows']);
    }

}
