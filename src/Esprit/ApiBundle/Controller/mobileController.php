<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 06/12/2017
 * Time: 14:23
 */

namespace Esprit\ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClientBundle\Entity\Promotion;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class mobileController extends Controller
{
    public function allAction()
    {  $datej=new \DateTime('now');
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Promotion p
    WHERE p.dateExpiration >=:d1 AND p.quantite!=:q ORDER BY  p.dateExpiration DESC'
        );
        $query->setParameter('d1',$datej);
        $query->setParameter('q',0);

        $promotions = $query->getResult();
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();
        //$promotions=$em->getRepository("ClientBundle:Promotion")->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=
$serializer->normalize($promotions,$enseignes);
        return new JsonResponse($formatted);
    }
    public function findAction($id)
    {
        //$em = $this->getDoctrine()->getManager();

       // $promotions=$em->getRepository("ClientBundle:Promotion")->find($id);
       // $promotion= new Promotion();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Promotion p WHERE 
    p.nom LIKE :word OR p.description LIKE :word1 '
        );
        $query->setParameter('word', '%'.$id.'%');
        $query->setParameter('word1', '%'.$id.'%');
        $promotions = $query->getResult();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=
        $serializer->normalize($promotions);
        return new JsonResponse($formatted);
    }
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
$promotion=new Promotion();
$promotion->setNom($request->get('name'));
$promotion->setQuantite($request->get('quantite'));
$promotion->setImage($request->get('imageurl'));
$promotion->setDescription($request->get('description'));
$promotion->setPrix($request->get('prix'));
        $datej=new \DateTime('now');
$promotion->setDateCreation($datej);
$promotion->setDateExpiration($datej);
$em->persist($promotion);
$em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=
            $serializer->normalize($promotion);
        return new JsonResponse($formatted);
    }

    public function affichParkAction($he,$date)
    {
        $em = $this->getDoctrine()->getManager();
// p.heuresortie<=:he AND
        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Parking p WHERE 
   p.heuresortie<=:he AND p.datepark >=:d'
        );
        $query->setParameter('d', $date);
       $query->setParameter('he', $he);
        $parkings = $query->getResult();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=
            $serializer->normalize($parkings);
        return new JsonResponse($formatted);
    }
    public function parkReserverAction($date,$he,$hs,$nbP)
    {




            $em=$this->getDoctrine()->getManager();
            $parking=$em->getRepository("ClientBundle:Parking")->find($nbP);

            $parking->setDatepark(\DateTime::createFromFormat('Y-m-d', $date));
            //  $parking->setHeuresortie('15:00');
            $parking->setHeureentree(\DateTime::createFromFormat('H:i',$he));
            $parking->setHeuresortie(\DateTime::createFromFormat('H:i', $hs));

            $em->persist($parking);
            $em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=
            $serializer->normalize($parking);
        return new JsonResponse($formatted);



    }
    public function quantiteAction($id,$qt)

    {
        $em=$this->getDoctrine()->getManager();
$x=0;
        $promo = $em->getRepository("ClientBundle:Promotion")->find($id);
        if($promo->getQuantite()<$qt)
        {$x=1;

            $serializer=new Serializer([new ObjectNormalizer()]);
            $formatted=
                $serializer->normalize($x);
            return new JsonResponse($formatted);
        }
        $promo->setQuantite($promo->getQuantite()-$qt);
        $em->persist($promo);
        $em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=
            $serializer->normalize($x);
        return new JsonResponse($formatted);
    }
    public function allpmAction($id)
    {
        //$em = $this->getDoctrine()->getManager();

        // $promotions=$em->getRepository("ClientBundle:Promotion")->find($id);
        // $promotion= new Promotion();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Promotion p WHERE 
    p.prix <:word ORDER BY p.prix'
        );
        $query->setParameter('word', $id);
       // $query->setParameter('word1', '%'.$id.'%');
        $promotions = $query->getResult();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=
            $serializer->normalize($promotions);
        return new JsonResponse($formatted);
    }
}