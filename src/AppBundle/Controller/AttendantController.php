<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attendant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $attendants = $em->getRepository('AppBundle:Attendant')->findByPage($request->query->getInt('page', 1),$this->container->getParameter('pagination'));

        return $this->render('attendant/index.html.twig', array(
            'attendants' => $attendants,
        ));
    }

    /**
     * Creates a new attendant entity.
     *
     * @Route("/new", name="attendant_new")
     * @Security("is_granted('ROLE_ADMIN')")
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

            $this->addFlash("success", "Encargado creado con éxito.");
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
     * @Security("is_granted('ROLE_ADMIN')")
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
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Attendant $attendant)
    {
        $deleteForm = $this->createDeleteForm($attendant);
        $editForm = $this->createForm('AppBundle\Form\AttendantType', $attendant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Encargado editado con éxito.");
            return $this->redirectToRoute('attendant_show', array('id' => $attendant->getId()));
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
     * @Route("/{id}/delete", name="attendant_delete")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method("post")
     */
    public function deleteAction(Request $request, Attendant $attendant)
    {
        $form = $this->createDeleteForm($attendant);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if(empty($em->getRepository('AppBundle:Attendant')->getFaunasByAttendant($attendant->getId()))){

              $attendant->setDeleted(true);
              $at='@';
              while(!is_null($em->getRepository('AppBundle:Attendant')->findOneBy(array('email'=>$at.$attendant->getEmail())))){
                $at=$at.'@';
              }
              $attendant->setEmail($at.$attendant->getEmail());
              $em->persist($attendant);
              $em->flush();

            }
            else{
              $this->addFlash("error", "No se pudo eliminar al encargado ya que tiene individuos de fauna a su cuidado.");
              return $this->redirectToRoute('attendant_index');
              //avisar que no se pudo borrar con toast
            }
            $this->addFlash("success", "Encargado eliminado con éxito.");
            return $this->redirectToRoute('attendant_index');
            //avisar que se pudo borrar con toast
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

    /**
     * Lists all attendant entities.
     *
     * @Route("/list/listJsonAttendant", name="listJsonAttendant")
     * @Method("GET")
     */
    public function listJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $attendants = $em->getRepository('AppBundle:Attendant')->findAll();
        $rawResponse = ['rows'];
          foreach($attendants as $attendant) {
            $rawResponse['rows'][] = array(
              'id' => $attendant->getId(),
              'name' => $attendant->getName(),
            );
          };
      return new JsonResponse($rawResponse['rows']);
    }
}
