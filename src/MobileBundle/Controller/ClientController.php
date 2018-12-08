<?php
/**
 * Created by PhpStorm.
 * User: RBS
 * Date: 01-Dec-17
 * Time: 2:42 PM
 */

namespace MobileBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ClientBundle\Entity\Cartefedalite;
use ClientBundle\Entity\User;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ClientController extends Controller
{
    public function findcartesAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $enseigne=$em->getRepository("ClientBundle:Enseigne")->findAll();
        $user=$em->getRepository("ClientBundle:User")->find($id);
        $carte=$em->getRepository("ClientBundle:Cartefedalite")->findBy(array("idclient"=>$id));
        if(empty($carte)){


        foreach ($enseigne as $ens){

            $cartesfidelite=$em->getRepository("ClientBundle:Cartefedalite")->findBy(array("idenseigne"=>$ens->getId(),"idclient"=>$id));
            if(empty($cartesfidelite)){
                $carte=new Cartefedalite();
                $carte->setIdenseigne($ens);
                $carte->setIdclient($user);
                $carte->setTotale(0);
                $carte->setNbrpts(50);
                $carte->setType("basic");
                $em->persist($carte);
                $em->flush();
            }
        }
        }

        $carte=$em->getRepository("ClientBundle:Cartefedalite")->findBy(array("idclient"=>$id));
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($carte);
       // $data=["id"=>1,"nom"=>"salah","cleint"=>["nomclient"=>"racem","salaire"=>"10000"]];
        return new JsonResponse($formatted);
    }

    public function loginAction()
    {
        $tasks=$em=$this->getDoctrine()->getManager()
            ->getRepository("ClientBundle:User")->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tasks);
        // $data=["id"=>1,"nom"=>"salah","cleint"=>["nomclient"=>"racem","salaire"=>"10000"]];
        return new JsonResponse($formatted);
    }


    public function updateuserAction($id,$nom,$prenom,$username,$password,$mail,$cin,$numtel)
    {
        $em=$this->getDoctrine()->getManager();
        $client=$em->getRepository("ClientBundle:User")->find($id);
        $client->setNom($nom);$client->setPrenom($prenom);$client->setUsername($username);$client->setPassword($password);
        $client->setEmail($mail);$client->setCin($cin);$client->setNumtel($numtel);
        $em->persist($client);
        $em->flush();
        return new JsonResponse("success");

    }

    public function adduserAction($nom,$prenom,$username,$password,$mail,$cin,$numtel)
    {
        $em=$this->getDoctrine()->getManager();
        $client=new User();
        $client->setNom($nom);$client->setPrenom($prenom);$client->setUsername($username);$client->setPassword($password);
        $client->setEmail($mail);$client->setCin($cin);$client->setNumtel($numtel);
        $i = 0;$pin = "";
        while($i < 4){
            //generate a random number between 0 and 9.
            $pin = $pin.mt_rand(0, 9);
            $i++;
        }

        $client->setCode($pin);
        $em->persist($client);
        $em->flush();

        return new JsonResponse($pin);

    }

    public function transformerAction($id,$bon)
    {

        $em=$this->getDoctrine()->getManager();
        $carte=$em->getRepository("ClientBundle:Cartefedalite")->find($id);
        $client=$em->getRepository("ClientBundle:User")->find($carte->getIdclient());
        $carte->setTotale($carte->getTotale()+$bon);
        if(($carte->getTotale()>1000)&&($carte->getTotale()<=4999)){

            $carte->setType("premium");
            $em->persist($carte);
            $em->flush();
        }
        if($carte->getTotale()>5000){

            $carte->setType("gold");
            $em->persist($carte);
            $em->flush();
        }



        $carte->setNbrpts(0);
        $em->persist($carte);
        $em->flush();


        return new JsonResponse("Points transforme");

    }

    public function searchcarteAction($id,$nom)
    {

        $enseigne=$em=$this->getDoctrine()->getManager()
            ->getRepository("ClientBundle:Enseigne")->findBy(array("nom"=>$nom));

        if(!empty($enseigne)){

            $enseigne=$em=$this->getDoctrine()->getManager()
                ->getRepository("ClientBundle:Enseigne")->findOneBy(array("nom"=>$nom));


       $cartes=$em=$this->getDoctrine()->getManager()
            ->getRepository("ClientBundle:Cartefedalite")->findBy(array("idclient"=>$id,"idenseigne"=>$enseigne->getId()));




        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($cartes);
        // $data=["id"=>1,"nom"=>"salah","cleint"=>["nomclient"=>"racem","salaire"=>"10000"]];*/
        return new JsonResponse($formatted);
}
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($enseigne);
        // $data=["id"=>1,"nom"=>"salah","cleint"=>["nomclient"=>"racem","salaire"=>"10000"]];*/
        return new JsonResponse($formatted);
    }


    public function setcodeAction($username,$code)
    {

        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository("ClientBundle:User")->findOneBy(array("username"=>$username));
if(!empty($user)){
    $user->setCode($code);
    $em->persist($user);
    $em->flush();
    return new JsonResponse("code seted");
}
else  return new JsonResponse("code is not seted");






    }


    public function alloffresAction(){
        $tasks=$this->getDoctrine()->getManager()
            ->getRepository('ClientBundle:Offresemplois')
            ->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
}