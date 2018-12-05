<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/faspecie/", name="app_list_faspecie")FASpecieRepository
     */
    public function listFaspecieAction(Request $request)
    {
        $db = $this->getDoctrine()->getManager();

        $listFASpecie = $db->getRepository('AppBundle:FASpecie')->findByPage(
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('faspecie/index.html.twig', array(
            'listFASpecie' => $listFASpecie
        ));
    }
}
