<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Flora;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $all = $request->query->all();
        $em = $this->getDoctrine()->getManager();
        $arrayParams = array(   'area' => isset($all["area"])? $all["area"]:NULL,
                                'specie' => isset($all["specie"])? $all["specie"]:NULL,
                                'subspecie' => isset($all["subspecie"])? $all["subspecie"]:NULL);
        $floras = $em->getRepository('AppBundle:Flora')->findByPage($request->query->getInt('page', 1),5,$arrayParams);
        return $this->render('flora/index.html.twig', array(
            'floras' => $floras,
            'params' =>$arrayParams
        ));
    }

    /**
     * Creates a new flora entity.
     *
     * @Route("/new", name="flora_new")
     * @Security("is_granted['ROLE_ADMIN','ROLE_DATA_ENTRY']")
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
            $this->addFlash("success", "Individuo creado con éxito.");
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
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
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
     * @Security("is_granted['ROLE_ADMIN','ROLE_DATA_ENTRY']")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Flora $flora)
    {
        $image_name = $flora->getImage();
        $deleteForm = $this->createDeleteForm($flora);
        $editForm = $this->createForm('AppBundle\Form\FloraType', $flora);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em=$this->getDoctrine()->getManager();

            // se guarda la imagen
            $file      = $editForm['image']->getData();
            if($file != null){
              $ext       = $file->guessExtension();
              $file_name = time().".".$ext;
              $file->move("uploads", $file_name);
              $flora->setImage($file_name);
            }
            else{
              $flora->setImage($image_name);
            }
            $em->persist($flora);
            $em->flush();

            $this->addFlash("success", "Individuo editado con éxito.");
            return $this->redirectToRoute('flora_show', array('id' => $flora->getId()));
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
     * @Route("/{id}/delete", name="flora_delete")
     * @Security("is_granted['ROLE_ADMIN','ROLE_DATA_ENTRY']")
     * @Method("post")
     */
    public function deleteAction(Request $request, Flora $flora)
    {
        $form = $this->createDeleteForm($flora);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $flora->setDeleted(true);
            $em->persist($flora);
            $em->flush();
        $this->addFlash("success", "Individuo eliminado con éxito.");
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
