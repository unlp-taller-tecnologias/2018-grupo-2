<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Flora;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
        $format = $this->setFormat($all);
        $em = $this->getDoctrine()->getManager();
        $arrayParams = array(   'area' => isset($all["area"])? $all["area"]:NULL,
                                'specie' => isset($all["specie"])? $all["specie"]:NULL,
                                'subspecie' => isset($all["subspecie"])? $all["subspecie"]:NULL,
                                'format' => $format
                                );
        $floras = $em->getRepository('AppBundle:Flora')->findByPage($request->query->getInt('page', 1),$this->container->getParameter('pagination'),$arrayParams);
        return $this->render(sprintf('flora/index.%s.twig', $format), array(
            'floras' => $floras,
            'params' =>$arrayParams
        ));
    }

    /**
     * Creates a new flora entity.
     *
     * @Route("/new", name="flora_new")
     * @Security("is_granted('ROLE_ADMIN','ROLE_DATA_ENTRY')")
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
            if($file != null){
              $ext       = $file->guessExtension();
              $file_name = time().".".$ext;
              $file->move("uploads", $file_name);
              $flora->setImage($file_name);
            }
            else{
              $flora->setImage(null);
            }

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
     * @Security("is_granted('ROLE_ADMIN','ROLE_DATA_ENTRY')")
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
     * @Security("is_granted('ROLE_ADMIN','ROLE_DATA_ENTRY')")
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

    private function setFormat($all)
    {
      if (isset($all["_format"]))
      {
        switch ($all["_format"]) {
          case "pdf":
            return "pdf";
          case "xls":
            return "xls";
        }
      }
      return "html";
    }
    /**
     * Lists all flspecie saveExcel.
     *
     * @Route("/save/excel", name="saveExcel")
     * @Method("GET")
     */
    public function saveExcel(Request $request)
    {
      $all = $request->query->all();
      $format = $this->setFormat($all);
      $em = $this->getDoctrine()->getManager();
      $arrayParams = array(   'area' => isset($all["area"])? $all["area"]:NULL,
                              'specie' => isset($all["specie"])? $all["specie"]:NULL,
                              'subspecie' => isset($all["subspecie"])? $all["subspecie"]:NULL,
                              'format' => $format
                              );
      $floras = $em->getRepository('AppBundle:Flora')->findByPage($request->query->getInt('page', 1),5,$arrayParams);
      // ask the service for a Excel5
      $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

      $phpExcelObject->getProperties()->setCreator("liuggio")
          ->setTitle("Floras")
          ->setSubject("Floras");

      $sheet = $phpExcelObject->setActiveSheetIndex(0);

      $sheet->setCellValue('A1', 'Especie');
      $sheet->setCellValue('B1', 'Subespecie');
      $sheet->setCellValue('C1', 'Nombre');
      $sheet->setCellValue('D1', 'Area');
      $sheet->setCellValue('E1', 'Fecha de plantación');

      $counter = 2;

      foreach ($floras as $flora) {
          $sheet->setCellValue('A'.$counter, $flora->getSubspecie()->getSpecie()->GetName());
          $sheet->setCellValue('B'.$counter, $flora->getSubspecie()->GetName());
          $sheet->setCellValue('C'.$counter, $flora->getName());
          $sheet->setCellValue('D'.$counter, $flora->getArea()->getName());
          $sheet->setCellValue('E'.$counter, $flora->getPlantationDate());
          $counter++;
      }

      $phpExcelObject->getActiveSheet()->setTitle("Floras");

      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $phpExcelObject->setActiveSheetIndex(0);

      // create the writer
      $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
      // create the response
      $response = $this->get('phpexcel')->createStreamedResponse($writer);
      // adding headers
      $dispositionHeader = $response->headers->makeDisposition(
          ResponseHeaderBag::DISPOSITION_ATTACHMENT,
          'Floras.xls'
      );
      $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
      $response->headers->set('Pragma', 'public');
      $response->headers->set('Cache-Control', 'maxage=1');
      $response->headers->set('Content-Disposition', $dispositionHeader);

      return $response;
    }
}
