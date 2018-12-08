<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 23/11/2017
 * Time: 11:20
 */

namespace TmBundle\Controller;


use ClientBundle\Entity\Cartefedalite;

use ClientBundle\Entity\Enseigne;
use ClientBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClientBundle\Entity\Offresemplois;

use TmBundle\Form\OffresemploisType;


class OffreController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function offreEmpAction()
    {
        //creer une instance de l'entity manager
        $em=$this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT v from ClientBundle:Offresemplois v where v.dateExperation>=CURRENT_DATE()'
        );


        $offres= $query->getResult();
        // $em=$this->getDoctrine()->getManager();
        //  $offres=$em->getRepository("ClientBundle:Offresemplois")->findoffreDql();
        return $this->render("TmBundle:tmtm:offre.html.twig",array('offres'=>$offres));
    }
    public function archiveoffreAction()
    {
        //creer une instance de l'entity manager

        $em=$this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT v from ClientBundle:Offresemplois v where v.dateExperation<=CURRENT_DATE()'
        );
        $offres= $query->getResult();
        return $this->render("TmBundle:tmtm:offrearchive.html.twig",array('offres'=>$offres));
    }
    public function offresupprimerAction(Request $request)
    {
        $id=$request->get('id' ) ;
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("ClientBundle:Offresemplois")->find($id);
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute("tm_offreEmp");

    }
    public function addoffreAction(Request $request){
        $Offresemplois=new Offresemplois();
        $form=$this->createForm(OffresemploisType::class,$Offresemplois);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($Offresemplois);
            $em->flush();
            return $this->redirectToRoute('tm_offreEmp');
        }
        return $this->render('TmBundle:tmtm:addoffre.html.twig',array("Form"=>$form->createView()));



    }
    public function updateoffreAction(Request $request)
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository('ClientBundle:Offresemplois')
            ->find($id);

        $form =$this->createForm(OffresemploisType::class,$offre);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('tm_offreEmp');
        }
        return $this->render('TmBundle:tmtm:updateoffre.html.twig',array("Form"=>$form->createView()));

    }

    }