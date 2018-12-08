<?php
/**
 * Created by PhpStorm.
 * User: RBS
 * Date: 22-Nov-17
 * Time: 5:33 PM
 */

namespace ClientBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Enseigne;
use ClientBundle\Entity\Reclamation ;
use TmBundle\Form\EnseigneType;
use TmBundle\Form\ReclamationType;



class EnseigneController extends Controller
{
    public function reclamationclientAction(Request $request)
    {

        $Reclamation= new Reclamation();
        $Form=$this->createForm(ReclamationType::class,$Reclamation);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $user = $this->getUser();
            $message = \Swift_Message::newInstance()->setSubject('Accusé de réception')
                ->setFrom('tunisiamalleverywhere@gmail.com')
                ->setTo($user->getEmail())
                ->setBody($this->renderView('ClientBundle:client:emailAmal.html.twig',array('nom'=>$user->getNom()),'text/html'));
            $this->get('mailer')->send($message);

            $em=$this->getDoctrine()->getManager();
            $em->persist($Reclamation);
            $em->flush();

            return $this->redirectToRoute('client_reclamation');


        }
        return $this->render("ClientBundle:client:reclamationclient.html.twig",array("Form"=>$Form->createView()));
    }





    public function enseigneAction()
    {
        $em=$this->getDoctrine()->getManager();
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();

        return $this->render('ClientBundle:client:enseigneclient.html.twig',array('enseignes'=>$enseignes));
    }

    public function voirplusenseigneAction(Request $request)
    {    $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $Enseigne=$em->getRepository('ClientBundle:Enseigne')->find($id);



        $nom=$Enseigne->getNom();
        $image=$Enseigne->getImage();
        $description=$Enseigne->getDescription();


        return $this->render('ClientBundle:client:voirplusenseigne.html.twig',array('nom'=>$nom ,'img'=>$image,'desc'=>$description));
    }


}