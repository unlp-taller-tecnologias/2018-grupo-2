<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fauna;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $all = $request->query->all();
        $format = $this->setFormat($all);
        $em = $this->getDoctrine()->getManager();
        $arrayParams = array(   'destination' => isset($all["destination"])? $all["destination"]:NULL,
                                'attendants' => isset($all["attendants"])? $all["attendants"]:NULL,
                                'specie' => isset($all["specie"])? $all["specie"]:NULL,
                                'subspecie' => isset($all["subspecie"])? $all["subspecie"]:NULL,
                                'format' => $format
                              );
        $faunas = $em->getRepository('AppBundle:Fauna')->findByPage($request->query->getInt('page', 1),$this->container->getParameter('pagination'),$arrayParams);
        return $this->render(sprintf('fauna/index.%s.twig', $format), array(
            'faunas' => $faunas,
            'params' =>$arrayParams
        ));
    }

    /**
     * Creates a new fauna entity.
     *
     * @Route("/new", name="fauna_new")
     * @Security("is_granted('ROLE_ADMIN','ROLE_DATA_ENTRY')")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fauna = new Fauna();
        $form = $this->createForm('AppBundle\Form\FaunaType', $fauna);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // se guarda la imagen
            $file      = $form['image']->getData();
            if($file != null){
              $ext       = $file->guessExtension();
              $file_name = time().".".$ext;
              $file->move("uploads", $file_name);
              $fauna->setImage($file_name);
            }
            else{
              $fauna->setImage(null);
            }
            $this->addFlash("success", "Individuo creado con éxito.");
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
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
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
     * @Security("is_granted('ROLE_ADMIN','ROLE_DATA_ENTRY')")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fauna $fauna)
    {
        $image_name = $fauna->getImage();
        $deleteForm = $this->createDeleteForm($fauna);
        $editForm = $this->createForm('AppBundle\Form\FaunaType', $fauna);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // se guarda la imagen
            $file      = $editForm['image']->getData();
            if($file != null){
              $ext       = $file->guessExtension();
              $file_name = time().".".$ext;
              $file->move("uploads", $file_name);
              $fauna->setImage($file_name);
            }
            else{
              $fauna->setImage($image_name);
            }
            $em->persist($fauna);
            $em->flush();
            $this->addFlash("success", "Individuo editado con éxito.");
            return $this->redirectToRoute('fauna_show', array('id' => $fauna->getId()));
        }

        return $this->render('fauna/edit.html.twig', array(
            'fauna' => $fauna,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a fauna entity.
     *
     * @Route("/{id}/delete", name="fauna_delete")
     * @Security("is_granted('ROLE_ADMIN','ROLE_DATA_ENTRY')")
     * @Method("post")
     */
    public function deleteAction(Request $request, Fauna $fauna)
    {
        $form = $this->createDeleteForm($fauna);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $fauna->setDeleted(true);
            $em->persist($fauna);
            $em->flush();
        $this->addFlash("success", "Individuo eliminado con éxito.");
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
     * @Route("/save/excel/fauna", name="saveExcelFaunas")
     * @Method("GET")
     */
    public function saveExcel(Request $request)
    {
      $all = $request->query->all();
      $format = $this->setFormat($all);
      $em = $this->getDoctrine()->getManager();
      $arrayParams = array(   'destination' => isset($all["destination"])? $all["destination"]:NULL,
                              'attendants' => isset($all["attendants"])? $all["attendants"]:NULL,
                              'specie' => isset($all["specie"])? $all["specie"]:NULL,
                              'subspecie' => isset($all["subspecie"])? $all["subspecie"]:NULL,
                              'format' => $format
                            );
      $faunas = $em->getRepository('AppBundle:Fauna')->findByPage($request->query->getInt('page', 1),5,$arrayParams);
      // ask the service for a Excel5
      $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

      $phpExcelObject->getProperties()->setCreator("liuggio")
          ->setTitle("Faunas")
          ->setSubject("Faunas");

      $sheet = $phpExcelObject->setActiveSheetIndex(0);

      $sheet->setCellValue('A1', 'Especie');
      $sheet->setCellValue('B1', 'Subespecie');
      $sheet->setCellValue('C1', 'Nombre');
      $sheet->setCellValue('D1', 'Peso');

      $counter = 2;

      foreach ($faunas as $fauna) {
          $sheet->setCellValue('A'.$counter, $fauna->getSubspecie()->getSpecie()->GetName());
          $sheet->setCellValue('B'.$counter, $fauna->getSubspecie()->GetName());
          $sheet->setCellValue('C'.$counter, $fauna->getName());
          $sheet->setCellValue('D'.$counter, $fauna->getWeight());
          $counter++;
      }

      $phpExcelObject->getActiveSheet()->setTitle("Faunas");

      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $phpExcelObject->setActiveSheetIndex(0);

      // create the writer
      $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
      // create the response
      $response = $this->get('phpexcel')->createStreamedResponse($writer);
      // adding headers
      $dispositionHeader = $response->headers->makeDisposition(
          ResponseHeaderBag::DISPOSITION_ATTACHMENT,
          'Faunas.xls'
      );
      $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
      $response->headers->set('Pragma', 'public');
      $response->headers->set('Cache-Control', 'maxage=1');
      $response->headers->set('Content-Disposition', $dispositionHeader);

      return $response;
    }
}
