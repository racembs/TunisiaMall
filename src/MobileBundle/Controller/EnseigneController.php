<?php
/**
 * Created by PhpStorm.
 * User: RBS
 * Date: 14-Dec-17
 * Time: 10:50 PM
 */

namespace MobileBundle\Controller;

use ClientBundle\Entity\Cartefedalite;

use ClientBundle\Entity\Enseigne;
use ClientBundle\Entity\Produit;
use ClientBundle\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use TmBundle\Form\ProduitType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

use ClientBundle\Entity\User;


class EnseigneController extends Controller
{

    public function AfficerAction(){

        $enseignes=$this->getDoctrine()->getManager()->getRepository('ClientBundle:Enseigne')->findAll();
        $serializer = new Serializer([new ObjectNormalizer() ]);
        $formatted=$serializer->normalize($enseignes);
        return new JsonResponse($formatted);

    }

    public function findAction($id){

        $enseignes=$this->getDoctrine()->getManager()->getRepository('ClientBundle:Enseigne')->find($id);
        $serializer = new Serializer([new ObjectNormalizer() ]);
        $formatted=$serializer->normalize($enseignes);
        return new JsonResponse($formatted);

    }

    public function findBoutiqueAction(){

        $enseignes=$this->getDoctrine()->getManager()->getRepository('ClientBundle:Enseigne')->findBy(array('categorie'=>'boutique'));
        $serializer = new Serializer([new ObjectNormalizer() ]);
        $formatted=$serializer->normalize($enseignes);
        return new JsonResponse($formatted);

    }


    public function findRestaurantAction(){

        $enseignes=$this->getDoctrine()->getManager()->getRepository('ClientBundle:Enseigne')->findBy(array('categorie'=>'restaurant'));
        $serializer = new Serializer([new ObjectNormalizer() ]);
        $formatted=$serializer->normalize($enseignes);
        return new JsonResponse($formatted);

    }



    public function newreclamAction(Request $request){

        $em=$this->getDoctrine()->getManager();
        $reclamation= new Reclamation() ;
        $reclamation->setNom($request->get('nom'));
        $reclamation->setPrenom($request->get('prenom'));
        $reclamation->setEmail($request->get('email'));
        $reclamation->setText($request->get('text'));
        $reclamation->setEtat($request->get('etat'));
        $em->persist($reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer() ]);
        $formatted=$serializer->normalize($reclamation);
        return new JsonResponse($formatted);





    }


    public function AllreclamAction(){

        $reclamations=$this->getDoctrine()->getManager()->getRepository('ClientBundle:Reclamation')->findAll();
        $serializer = new Serializer([new ObjectNormalizer() ]);
        $formatted=$serializer->normalize($reclamations);
        return new JsonResponse($formatted);

    }

    public function findBoutiqueDescAction($description){

        $enseignes=$this->getDoctrine()->getManager()->getRepository('ClientBundle:Enseigne')
            ->findBy(array('description'=>$description,'categorie'=>"boutique"));
        $serializer = new Serializer([new ObjectNormalizer() ]);
        $formatted=$serializer->normalize($enseignes);
        return new JsonResponse($formatted);

    }


    public function findRestDescAction($description){

        $enseignes=$this->getDoctrine()->getManager()->getRepository('ClientBundle:Enseigne')
            ->findBy(array('description'=>$description,'categorie'=>"restaurant"));
        $serializer = new Serializer([new ObjectNormalizer() ]);
        $formatted=$serializer->normalize($enseignes);
        return new JsonResponse($formatted);

    }

}