<?php
/**
 * Created by PhpStorm.
 * User: RBS
 * Date: 09-Dec-17
 * Time: 4:21 PM
 */

namespace MobileBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClientBundle\Entity;
use ClientBundle\Entity\User;
use ClientBundle\Entity\Commande;
use ClientBundle\Entity\Lignecommande;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
class PanierController extends Controller
{
    public function paiementAction($id,$adresse,$tel,$ville,$pays)
    {
        $em = $this->getDoctrine()->getManager();
        $test=0;

        $commande = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $test));



        $commande->setLivraison(1);
        $commande->setPaiement(1);
        $commande->setAdresse($adresse);
        $commande->setNum($tel);
        $commande->setVille($ville);
        $commande->setPays($pays);
        $commande->setDate(new \DateTime());

        $commande->setEtat(1);


        $em->persist($commande);
        $em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($commande);
        return new JsonResponse($formatted);

    }

    public function allsAction($id)
    {
        $etat=0;
        $em=$this->getDoctrine()->getManager();
        $CMD1 = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $etat));



        $Lignecommande = $em->getRepository('ClientBundle:Lignecommande')->findby(array("idcommande" => $CMD1->getId()));

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize( $Lignecommande);
        return new JsonResponse($formatted);

    }
    public function supprimerlcAction($id)
    {   $em = $this->getDoctrine()->getManager();
        $etat = 0;
        $CMD1 = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id,"etat" => $etat));
        $em->remove($CMD1);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($CMD1);
        return new JsonResponse($formatted);
    }
    public function supprimerLComAction($id)
    {   $em = $this->getDoctrine()->getManager();
        $Lignecommande = $em->getRepository('ClientBundle:Lignecommande')->find($id);
        $em->remove($Lignecommande);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($Lignecommande);
        return new JsonResponse($formatted);
    }
    public function authoAction()
    {
        $tasks=$em=$this->getDoctrine()->getManager()
            ->getRepository("ClientBundle:Paiement")->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tasks);
        // $data=["id"=>1,"nom"=>"salah","cleint"=>["nomclient"=>"racem","salaire"=>"10000"]];
        return new JsonResponse($formatted);
    }
    public function modifqtAction($id,$qt)
    {$em = $this->getDoctrine()->getManager();
        $Lignecommande = $em->getRepository('ClientBundle:Lignecommande')->find($id);
        $Lignecommande->setQuantite($qt);

        $promo = $Lignecommande->getPromo();

        $prix = $Lignecommande->getPrix();
        $total = $prix * $promo *$qt;

        $Lignecommande->setTotal($total);
        $em->persist($Lignecommande);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($Lignecommande);
        // $data=["id"=>1,"nom"=>"salah","cleint"=>["nomclient"=>"racem","salaire"=>"10000"]];
        return new JsonResponse($formatted);
    }

    public function ajouterlcAction($id,$idProduit,$qt)
    {$em = $this->getDoctrine()->getManager();
        $etat = 0;
        $user = $em->getRepository("ClientBundle:User")->find($id);

        $CMD1 = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $etat));

        if(empty($CMD1)) {
            $CMD1 = new Commande();
            $CMD1->setIdclient($user);
            $etat = 0;
            $CMD1->setEtat($etat);
            $em->persist($CMD1);
            $em->flush();
            $serializer=new Serializer([new ObjectNormalizer()]);
            $formatted=$serializer->normalize($CMD1);
            // $data=["id"=>1,"nom"=>"salah","cleint"=>["nomclient"=>"racem","salaire"=>"10000"]];
            return new JsonResponse($formatted);
        }
        $produit = $em->getRepository("ClientBundle:Produit")->find($idProduit);
        $ligneCMD = new Lignecommande();
        $ligneCMD->setIdproduit($produit);
        $ligneCMD->setIdcommande($CMD1);
        $ligneCMD->setPrix($produit->getPrix());
        $ligneCMD->setQuantite($qt);
        $promo = $produit->getPromo();
        $prix = $produit->getPrix();
        $total = $prix * $promo ;
        $ligneCMD->setPromo($produit->getPromo());
        $ligneCMD->setTotal($total);

        $em->persist($ligneCMD);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($ligneCMD);
        // $data=["id"=>1,"nom"=>"salah","cleint"=>["nomclient"=>"racem","salaire"=>"10000"]];
        return new JsonResponse($formatted);
    }
    public function cmdAction($id)
    { $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("ClientBundle:User")->find($id);
        $CMD1 = new Commande();
        $CMD1->setIdclient($user);
        $etat = 0;
        $CMD1->setEtat($etat);
        $em->persist($CMD1);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($CMD1);
        // $data=["id"=>1,"nom"=>"salah","cleint"=>["nomclient"=>"racem","salaire"=>"10000"]];
        return new JsonResponse($formatted);
    }

}