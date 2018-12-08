<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 23/11/2017
 * Time: 11:20
 */

namespace ClientBundle\Controller;


use ClientBundle\Entity\Cartefedalite;

use ClientBundle\Entity\Enseigne;
use ClientBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClientBundle\Entity\Offresemplois;
class OffreController extends Controller
{
    public function offreEmpAction()
    {
        //creer une instance de l'entity manager
        $em=$this->getDoctrine()->getManager();
        $offres=$em->getRepository("ClientBundle:Offresemplois")->findoffreDql();
        return $this->render("ClientBundle:client:offreEmp.html.twig",array('offres'=>$offres));

    }
    public function search2Action(Request $request){

        $em = $this->getDoctrine()->getManager();


        $offres = $em->getRepository("ClientBundle:Offresemplois")->findoffreDql();

        if($request->isMethod("post"))
        {           if($request=="")
        {  $offres = $em->getRepository("ClientBundle:Offresemplois")->findoffreDql();

        } else {
            $criteria = $request->get('criteria');
            $offres = $em->getRepository("ClientBundle:Offresemplois")->findlike($criteria); }
            //echo"suite au clique sue le bouton submit";

        }
        return $this->render("ClientBundle:client:offreEmp.html.twig",array("offres"=>$offres));


    }
}