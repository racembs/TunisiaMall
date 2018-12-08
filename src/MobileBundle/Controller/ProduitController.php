<?php
/**
 * Created by PhpStorm.
 * User: HP-PC
 * Date: 07/12/2017
 * Time: 19:32
 */

namespace MobileBundle\Controller;
use ClientBundle\Entity\Jaim;
use ClientBundle\Entity\Produit;
use ClientBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ProduitController extends Controller
{

    public function allAction()
    {
        $produits=$this->getDoctrine()->getManager()->getRepository('ClientBundle:Produit')->findAll();
        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produits);
        return new JsonResponse($formatted);
    }





    public function LikeMobileAction($iduser,$idproduit )
    {

        $em= $this->getDoctrine()->getManager();
        // $user=$this->getUser();
        // $idu=$user->getId();

        // $id=$request->get('id');
        $user=$em->getRepository('ClientBundle:User')->find($iduser);
        $Produit=$em->getRepository('ClientBundle:Produit')->find($idproduit);
        $jaim=$em->getRepository('ClientBundle:Jaim')->findOneBy(array('idClient'=>$iduser,'idroduit'=>$idproduit));
        // $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();


        $x=0;
        if(empty($jaim)){
            $msg='';
            $jaim=new Jaim();
            $jaim->setEtat(1);
            $Produit->setNbjaimes($Produit->getNbjaimes() + 1);
            $jaim-> setIdClient($user);
            $jaim-> setIdroduit($Produit);
            $em->persist($jaim);
            $em->persist($Produit);
            $em->flush();

            $x=1;
            $serializer=new  Serializer([new ObjectNormalizer()]);
            $formatted=$serializer->normalize($x);
            return new JsonResponse($formatted);
            //  return $this->render('ClientBundle:client:index.html.twig',array('msg'=>$msg,'produit'=>$Produit,'enseignes'=>$enseignes));

        }



        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($x);
        return new JsonResponse($formatted);


        //  $msg  =  'Vous avez effectué deja un jaime sur ce produit';


        //   return $this->render('ClientBundle:client:index.html.twig',array('msg'=>$msg,'produit'=>$Produit,'enseignes'=>$enseignes));


    }






    public function DislikeMobileAction($iduser,$idproduit)
    {

        $em= $this->getDoctrine()->getManager();
        // $user=$this->getUser();
        // $idu=$user->getId();

        // $id=$request->get('id');
        $user=$em->getRepository('ClientBundle:User')->find($iduser);
        $Produit=$em->getRepository('ClientBundle:Produit')->find($idproduit);
        $jaim=$em->getRepository('ClientBundle:Jaim')->findOneBy(array('idClient'=>$iduser,'idroduit'=>$idproduit));
        // $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

        $x=0;
        if(!empty($jaim)){
            $msg='';
            //$jaim=new Jaim();
            //$jaim->setEtat(1);
            // $Produit->setNbjaimes($Produit->getNbjaimes() + 1);
            // $jaim-> setIdClient($user);
            // $jaim-> setIdroduit($Produit);
            $em->remove($jaim);
            //$em->persist($Produit);
            $em->flush();

            $x=1;
            $serializer=new  Serializer([new ObjectNormalizer()]);
            $formatted=$serializer->normalize($x);
            return new JsonResponse($formatted);
            //  return $this->render('ClientBundle:client:index.html.twig',array('msg'=>$msg,'produit'=>$Produit,'enseignes'=>$enseignes));

        }
        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($x);
        return new JsonResponse($formatted);


        //  $msg  =  'Vous avez effectué deja un jaime sur ce produit';


        //   return $this->render('ClientBundle:client:index.html.twig',array('msg'=>$msg,'produit'=>$Produit,'enseignes'=>$enseignes));


    }





    public function produitSearchAction($criteria)
    {

        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository("ClientBundle:Produit")->findBy(array('nom'=>$criteria));


        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produit);
        return new JsonResponse($formatted);
        //  return $this->render('ClientBundle:

    }


    public function filtreAction()
    {

        $produit= new Produit();
        $em = $this->getDoctrine()->getManager();
        //$produits = $em->getRepository("ClientBundle:Produit")->findAll();
        //$enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

        $msg='';

        $datej=new \DateTime('now');

        $week=date("Y-m-d", strtotime("-1 week"));

        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.date >=:d1 '
        );
        $query->setParameter('d1',$week);

        $produits = $query->getResult();


        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produits);
        return new JsonResponse($formatted);
    }



    public function FemmesAction()
    {

        $produit= new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();


        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.categorie =:f'
        );
        $query->setParameter('f',"Femme");
        $produits = $query->getResult();


        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produits);
        return new JsonResponse($formatted);



    }




    public function HommesAction()
    {

        $produit= new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();


        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.categorie =:h'
        );
        $query->setParameter('h',"Homme");
        $produits = $query->getResult();


        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produits);
        return new JsonResponse($formatted);



    }


    public function EnfantsAction()
    {

        $produit= new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();


        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.categorie =:e'
        );
        $query->setParameter('e',"Enfant");
        $produits = $query->getResult();


        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produits);
        return new JsonResponse($formatted);



    }


    public function AccessoiresAction()
    {

        $produit= new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();


        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.categorie =:a'
        );
        $query->setParameter('a',"Accessoires");
        $produits = $query->getResult();


        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produits);
        return new JsonResponse($formatted);



    }




    public function PrixAction($prix)
    {

        $produit= new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();


        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.prix <:p'
        );
        $query->setParameter('p',$prix);
        $produits = $query->getResult();


        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($produits);
        return new JsonResponse($formatted);



    }


    public function StatFemmeAction()
    {

        $em = $this->container->get('doctrine')->getEntityManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $tab = array();
        $categories = array();

        $nbF = 0;
        $nbH = 0;
        $nbE = 0;
        $nbA = 0;
        foreach ($produits as $pd) {
            if ($pd->getCategorie() == "Femme") {
                $nbF = $nbF + $pd->getNbjaimes();

                array_push($categories, "Femme");
            }
        }


        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($nbF);
        return new JsonResponse($formatted);

    }



    public function StatHommeAction()
    {

        $em = $this->container->get('doctrine')->getEntityManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $tab = array();
        $categories = array();

        $nbF = 0;
        $nbH = 0;
        $nbE = 0;
        $nbA = 0;
        foreach ($produits as $pd) {
            if ($pd->getCategorie() == "Homme") {
                $nbH = $nbH + $pd->getNbjaimes();

                array_push($categories, "Homme");
            }
        }

        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($nbH);
        return new JsonResponse($formatted);

    }


    public function StatAccessoireAction()
    {

        $em = $this->container->get('doctrine')->getEntityManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $tab = array();
        $categories = array();

        $nbF = 0;
        $nbH = 0;
        $nbE = 0;
        $nbA = 0;
        foreach ($produits as $pd) {
            if ($pd->getCategorie() == "Accessoires") {
                $nbA = $nbA + $pd->getNbjaimes();

                array_push($categories, "Accessoires");
            }
        }

        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($nbA);
        return new JsonResponse($formatted);

    }


    public function StatEnfantAction()
    {

        $em = $this->container->get('doctrine')->getEntityManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $tab = array();
        $categories = array();

        $nbF = 0;
        $nbH = 0;
        $nbE = 0;
        $nbA = 0;
        foreach ($produits as $pd) {
            if ($pd->getCategorie() == "Enfant") {
                $nbE = $nbE + $pd->getNbjaimes();

                array_push($categories, "Enfant");
            }
        }

        $serializer=new  Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($nbE);
        return new JsonResponse($formatted);

    }



}