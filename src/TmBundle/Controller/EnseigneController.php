<?php
/**
 * Created by PhpStorm.
 * User: RBS
 * Date: 22-Nov-17
 * Time: 5:33 PM
 */

namespace TmBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Enseigne;
use TmBundle\Form\EnseigneType;



class EnseigneController extends Controller
{
    public function deleteenseigneACtion(Request $request)
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $Enseigne=$em->getRepository("ClientBundle:Enseigne")->find($id);
        $em->remove($Enseigne);
        $em->flush();
        return ($this->redirectToRoute("tm_enseigne"));


    }

    public function addenseigneACtion(Request $request)
    {  $Enseigne= new Enseigne();
        $Form=$this->createForm(EnseigneType::class,$Enseigne);
        $Form->handleRequest($request);
        if ($Form->isValid()){
            $dir="D:\\wamp64\\www\\TMpi\\web\\images";
            $file=$Form['image']->getData();
            $Enseigne->setImage($Enseigne->getNom().".png");
            $file->move($dir,$Enseigne->getImage());

            $em=$this->getDoctrine()->getManager();
            $em->persist($Enseigne);
            $em->flush();
            return $this->redirectToRoute('tm_enseigne');
        }
        return $this->render("TmBundle:tmtm:addenseigne.html.twig",array("Form"=>$Form->createView()));


    }

    public function updateenseigneACtion(Request $request , $id)
    {
        $em=$this->getDoctrine()->getManager();
        $Enseigne= $em->getRepository('ClientBundle:Enseigne')->find($id);
        $form=$this->createForm(EnseigneType::class,$Enseigne);
        $form->handleRequest($request);
        if ($form->isValid()){

            $dir="D:\\wamp64\\www\\TMpi\\web\\images";

            $file = $form['image']->getData();
            $Enseigne->setImage($Enseigne->getNom().".png");

            $file->move($dir, $Enseigne->getImage());
            $em->persist($Enseigne);
            $em->flush();
            return $this->redirect( $this->generateUrl("tm_enseigne"));

            $em->persist($Enseigne);
            $em->flush();
            return $this->redirectToRoute('tm_enseigne');
        }
        return $this->render("TmBundle:tmtm:updateenseigne.html.twig",array("form"=>$form->createView()));}


    public function searchEnseigneAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $enseignes=$em->getRepository("ClientBundle:Enseigne")
            ->findAll();
        if($request->isMethod("POST"))
        {
            $criteria=$request->get('criteria') ;
            $em=$this->getDoctrine()->getManager();

            $enseignes=$em->getRepository("ClientBundle:Enseigne")->findBy(array("nom"=>$criteria));

        }
        return $this->render("TmBundle:tmtm:searchEnseigne.html.twig",array("enseignes"=>$enseignes));
    }

    public function reclamationsAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $reclamations=$em->getRepository("ClientBundle:Reclamation")->findAll();
        if($request->isMethod("POST"))
        {
            $criteria='urgent' ;
            $em=$this->getDoctrine()->getManager();

            $reclamations=$em->getRepository("ClientBundle:Reclamation")->findBy(array("etat"=>$criteria));

        }


        return $this->render("TmBundle:tmtm:reclamations.html.twig",array('reclamations'=>$reclamations));
    }


}