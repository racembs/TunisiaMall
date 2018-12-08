<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 18/11/2017
 * Time: 14:37
 */

namespace ClientBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ClientBundle\Entity\Parking;


class parkingController extends Controller
{
    public function disponibleAction(Request $request)
    {  $datej=new \DateTime('now');
    $datej2=$datej->format('Y-m-d');
        $parking= new Parking();
        $em = $this->getDoctrine()->getManager();


        if($request->isMethod("POST")) {

// WHERE p.datepark >=:d AND
   if($request->get('date')<$datej2){
      $msg='date invalide : doit etre superieure ou egale au date de jour';
      return $this->render('ClientBundle:client:parking.html.twig', array('msg' => $msg));

   }
   else
   {$msg='';
            $query = $em->createQuery(
                'SELECT p
    FROM ClientBundle:Parking p WHERE 
    p.heuresortie<=:he AND p.datepark >=:d'
            );
       $query->setParameter('d', $request->get('date'));
            $query->setParameter('he', $request->get('he'));


            $parkings = $query->getResult();
$diff=$request->get('hs')-$request->get('he');


            return $this->render('ClientBundle:client:parkingAffiche.html.twig', array('msg' => $msg,'parkings' => $parkings,
                    'frais'=>$diff,'date'=>$request->get('date'),'he'=>$request->get('he'),'hs'=>$request->get('hs'))
            );
   }}
        else
            return $this->redirectToRoute('parking');



    }
    public function disponibleafficheAction()
    {  $datej=new \DateTime('now');
    $msg='';
        return $this->render('ClientBundle:client:parking.html.twig',array('datej'=>$datej,'msg'=>$msg)
        );
    }
    public function qrAfficheAction(Request $request)
    {


        $parking=new Parking();
        if($request->isMethod('POST')){


                    $nbP = $request->get('nbP');
                    $em=$this->getDoctrine()->getManager();
                    $parking=$em->getRepository("ClientBundle:Parking")->find($nbP);
 $date= $request->get('date');
  $parking->setDatepark(\DateTime::createFromFormat('Y-m-d', $request->get('date')));
          //  $parking->setHeuresortie('15:00');
            $parking->setHeureentree(\DateTime::createFromFormat('H:i', $request->get('he')));
            $parking->setHeuresortie(\DateTime::createFromFormat('H:i', $request->get('hs')));

                $em->persist($parking);
            $em->flush();
           $user = $this->getUser();


            $codepark=$date."".$request->get('he')."".$request->get('hs').$user->getCin().$parking->getNumplaces();
                    return $this->render('ClientBundle:client:qr.html.twig', array('nom'=>$user->getNom(),'prenom'=>$user->getPrenom(),'codepark'=>$codepark)
                    );
        }
                    else
                        return $this->render('ClientBundle:client:parking.html.twig'
                        );


    }

}