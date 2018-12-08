<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 08/11/2017
 * Time: 15:17
 */

namespace ClientBundle\Controller;
use ClientBundle\Entity\Cartefedalite;

use ClientBundle\Entity\Enseigne;
use ClientBundle\Entity\Jaim;
use ClientBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use TmBundle\Form\ProduitType;

class ClientController extends Controller
{
    public function homeAction()
    {$msg="";
        $produit= new Produit();
        $em = $this->getDoctrine()->getManager();
        //$produits = $em->getRepository("ClientBundle:Produit")->findAll();
        //$enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

        $datej=new \DateTime('now');

        $week=date("Y-m-d", strtotime("-1 week"));

        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.date >=:d1 '
        );
        $query->setParameter('d1',$week);

        $produits = $query->getResult();
        return $this->render('ClientBundle:client:index.html.twig',array('produits'=>$produits,'msg'=>$msg));
    }
    public function fideliteAction()
    {

        $user = $this->getUser();
        $id=$user->getId();
        $em=$this->getDoctrine()->getManager();

        $enseigne=$em->getRepository("ClientBundle:Enseigne")->findAll();

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



        $cartesfidelite=$em->getRepository("ClientBundle:Cartefedalite")->findBy(array("idclient"=>$id));

        foreach ($cartesfidelite as $carte ){
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

        }

        $cartesfidelite=$em->getRepository("ClientBundle:Cartefedalite")->findBy(array("idclient"=>$id));
        return $this->render('ClientBundle:client:fidelite.html.twig',array("cartes"=>$cartesfidelite));
    }
    public function transformerAction(Request $request)
    {
        $bon=$request->get('bon');
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $carte=$em->getRepository("ClientBundle:Cartefedalite")->find($id);
        $client=$em->getRepository("ClientBundle:User")->find($carte->getIdclient());
        $carte->setTotale($carte->getTotale()+$bon);




        $snappy = $this->get('knp_snappy.pdf');
        $date=new \DateTime('now');
        $html = $this->renderView('ClientBundle:client:bon.html.twig', array(
            'carte' => $carte,'client'=>$client,'date'=>$date
        ));
        $carte->setNbrpts(0);
        $em->persist($carte);
        $em->flush();
        $filename = "bon d'achat";

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )

        );
        return $this->redirectToRoute("client_fidelite");


    }

    public function compteAction()
    {

        $user = $this->getUser();
        $id=$user->getId();
        $em=$this->getDoctrine()->getManager();

       return $this->render('ClientBundle:client:modifcompte.html.twig');
    }
    public function modifmailAction(Request $request)
    {
        $user = $this->getUser();
        $id=$user->getId();
        $em=$this->getDoctrine()->getManager();
        $client=$em->getRepository("ClientBundle:User")->find($id);


        if($request->isMethod("POST")){
            $mail=$request->get("mail");
            $client->setEmail($mail);
            $em->persist($client);
            $em->flush();
            return  $this->redirectToRoute("client_compte");
        }
        return $this->render('ClientBundle:client:modifmail.html.twig',array("mail"=>$client->getEmail())
        );

    }
    public function modifusernameAction(Request $request)
    {
        $user = $this->getUser();
        $id=$user->getId();
        $em=$this->getDoctrine()->getManager();
        $client=$em->getRepository("ClientBundle:User")->find($id);


        if($request->isMethod("POST")){
            $username=$request->get("username");
            $client->setUsername($username);
            $em->persist($client);
            $em->flush();
            return  $this->redirectToRoute("client_compte");
        }
        return $this->render('ClientBundle:client:modifusername.html.twig',array("username"=>$client->getUsername())
        );

    }


    public function HommeProduitAction()
    {

        $produit= new Produit();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

$msg='';
        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.categorie =:h'
        );
        $query->setParameter('h',"Homme");
        $produits = $query->getResult();


        return $this->render('ClientBundle:client:HommeProduit.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));

    }


    public function voirplusAction(Request $request)
    {
        $id=$request->get('id');

        $em= $this->getDoctrine()->getManager();
        $Produit=$em->getRepository('ClientBundle:Produit')->find($id);
        $Enseigne=$em->getRepository('ClientBundle:Enseigne')->findAll();


        $reference=$Produit->getReference();
            $nom=$Produit->getNom();
             $categorie=$Produit->getCategorie();
                $prix=$Produit->getPrix();
                    $description=$Produit->getDescription();
                        $promo=$Produit->getPromo();
                            $image=$Produit->getImage();
                                $nbjaimes=$Produit->getNbjaimes();
                                $enseigne=$Produit->getIdenseigne()->getNom();



            return $this->render('ClientBundle:client:VoirPlus.html.twig',array('ref'=>$reference,'nom'=>$nom,'cat'=>$categorie,'p'=>$prix,'des'=>$description,'pro'=>$promo,'img'=>$image,'nb'=>$nbjaimes,'e'=>$enseigne));





    }

    public function LikeProduitAction(Request $request)
    {

        $em= $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $idu=$user->getId();

        $id=$request->get('id');

        $Produit=$em->getRepository('ClientBundle:Produit')->find($id);
        $jaim=$em->getRepository('ClientBundle:Jaim')->findOneBy(array('idClient'=>$idu,'idroduit'=>$id));
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

        $datej=new \DateTime('now');

        $week=date("Y-m-d", strtotime("-1 week"));

        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.date >=:d1 '
        );
        $query->setParameter('d1',$week);

        $produits = $query->getResult();

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
            return $this->render('ClientBundle:client:index.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));

        }



        $msg  =  'Vous avez effectué deja un jaime sur ce produit';


        return $this->render('ClientBundle:client:index.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));


    }


    public function LikeProduitHommeAction(Request $request)
    {

        $em= $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $idu=$user->getId();

        $id=$request->get('id');

        $Produit=$em->getRepository('ClientBundle:Produit')->find($id);
        $jaim=$em->getRepository('ClientBundle:Jaim')->findOneBy(array('idClient'=>$idu,'idroduit'=>$id));
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.categorie =:h'
        );
        $query->setParameter('h',"Homme");
        $produits = $query->getResult();

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
            return $this->render('ClientBundle:client:HommeProduit.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));

        }



        $msg  =  'Vous avez effectué deja un jaime sur ce produit';


        return $this->render('ClientBundle:client:HommeProduit.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));


    }

    public function LikeProduitFemmeAction(Request $request)
    {

        $em= $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $idu=$user->getId();

        $id=$request->get('id');
        $msg='';
        $Produit=$em->getRepository('ClientBundle:Produit')->find($id);
        $jaim=$em->getRepository('ClientBundle:Jaim')->findOneBy(array('idClient'=>$idu,'idroduit'=>$id));
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.categorie =:f'
        );
        $query->setParameter('f',"Femme");
        $produits = $query->getResult();

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
            return $this->render('ClientBundle:client:FemmeProduit.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));

        }



        $msg  =  'Vous avez effectué deja un jaime sur ce produit';


        return $this->render('ClientBundle:client:FemmeProduit.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));


    }

    public function LikeProduitAccessoiresAction(Request $request)
    {

        $em= $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $idu=$user->getId();

        $id=$request->get('id');
        $msg='';
        $Produit=$em->getRepository('ClientBundle:Produit')->find($id);
        $jaim=$em->getRepository('ClientBundle:Jaim')->findOneBy(array('idClient'=>$idu,'idroduit'=>$id));
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.categorie =:a'
        );
        $query->setParameter('a',"Accessoires");
        $produits = $query->getResult();

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
            return $this->render('ClientBundle:client:AccessoireProduit.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));

        }



        $msg  =  'Vous avez effectué deja un jaime sur ce produit';


        return $this->render('ClientBundle:client:AccessoireProduit.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));


    }

    public function LikeProduitEnfantAction(Request $request)
    {

        $em= $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $idu=$user->getId();

        $id=$request->get('id');
        $msg='';
        $Produit=$em->getRepository('ClientBundle:Produit')->find($id);
        $jaim=$em->getRepository('ClientBundle:Jaim')->findOneBy(array('idClient'=>$idu,'idroduit'=>$id));
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Produit p
    WHERE p.categorie =:e'
        );
        $query->setParameter('e',"Enfant");
        $produits = $query->getResult();

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
            return $this->render('ClientBundle:client:EnfantProduit.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));

        }



        $msg  =  'Vous avez effectué deja un jaime sur ce produit';


        return $this->render('ClientBundle:client:EnfantProduit.html.twig',array('msg'=>$msg,'produits'=>$produits,'enseignes'=>$enseignes));


    }


    public function FemmeProduitAction(Request $request)
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
        $query->setParameter('h',"Femme");
        $produits = $query->getResult();


        return $this->render('ClientBundle:client:FemmeProduit.html.twig',array('produits'=>$produits,'enseignes'=>$enseignes));

    }

    public function AccessoireProduitAction(Request $request)
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
        $query->setParameter('h',"Accessoires");
        $produits = $query->getResult();


        return $this->render('ClientBundle:client:AccessoireProduit.html.twig',array('produits'=>$produits,'enseignes'=>$enseignes));


    }

    public function EnfantProduitAction(Request $request)
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
        $query->setParameter('h',"Enfant");
        $produits = $query->getResult();


        return $this->render('ClientBundle:client:EnfantProduit.html.twig',array('produits'=>$produits,'enseignes'=>$enseignes));


    }


    public function onsAction(Request $request)
    {






        return $this->render('ClientBundle:client:ons.html.twig');


    }
	   public function promononExpAction()
    { $msg='';
        $produit= new Produit();
        $em = $this->getDoctrine()->getManager();
        //$produits = $em->getRepository("ClientBundle:Produit")->findAll();
        //$enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

        $datej=new \DateTime('now');
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();

        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Promotion p
    WHERE p.dateExpiration >=:d1 AND p.quantite!=:q'
        );
        $query->setParameter('d1',$datej);
        $query->setParameter('q',0);

        $promotions = $query->getResult();
        return $this->render('ClientBundle:client:promoClient.html.twig',array('msg'=>$msg,'promotions'=>$promotions,'enseignes'=>$enseignes
        ));
    }
    public function quantiteAction(Request $request)
    { if ($request->isMethod("POST"))
    {
        $qt=$request->get('qt');
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();

        $promo = $em->getRepository("ClientBundle:Promotion")->find($id);
        if($promo->getQuantite()<$qt)
        {
            $msg='quantité invalide';
            $em = $this->getDoctrine()->getManager();
            //$produits = $em->getRepository("ClientBundle:Produit")->findAll();
            //$enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();

            $datej=new \DateTime('now');
            $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();

            $query = $em->createQuery(
                'SELECT p
    FROM ClientBundle:Promotion p
    WHERE p.dateExpiration >=:d1 AND p.quantite!=:q'
            );
            $query->setParameter('d1',$datej);
            $query->setParameter('q',0);

            $promotions = $query->getResult();
            return $this->render('ClientBundle:client:promoClient.html.twig',array('msg'=>$msg,'promotions'=>$promotions,'enseignes'=>$enseignes
            ));
        }
        $promo->setQuantite($promo->getQuantite()-$qt);
        $em->persist($promo);
        $em->flush();
        $user = $this->getUser();
        $message = \Swift_Message::newInstance()->setSubject('Promotion reservée avec succées (TM)')
            ->setFrom('tunisiamalleverywhere@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($this->renderView('ClientBundle:client:email.html.twig',array('nom'=>$user->getNom(),'prenom'=>$user->getPrenom(),'qt'=>$qt,'promo'=>$promo->getNom(),'enseigne'=>$promo->getIdenseignepromo()->getNom()),'text/html'));
        $this->get('mailer')->send($message);
        // return new Response('ok');
        return $this->redirectToRoute('promo_Client');

    }
        return new Response('no');
    }
    public function search_keyword(Request $request)
    {
        $promotion= new Promotion();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ClientBundle:Promotion")->findAll();
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();


        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Promotion p
    WHERE p.nom =:h'
        );
        $query->setParameter('h',$request->get('id'));
        $promotion = $query->getResult();


        return $this->render('ClientBundle:client:HommeProduit.html.twig',array('promotion'=>$promotion,'enseignes'=>$enseignes));

    }
    public function voirplusPromoAction(Request $request)
    {
        $id=$request->get('id');

        $em= $this->getDoctrine()->getManager();
        $Produit=$em->getRepository('ClientBundle:Promotion')->find($id);
        $Enseigne=$em->getRepository('ClientBundle:Enseigne')->findAll();

        $id=$Produit->getID();
        $reference=$Produit->getNom();
        $nom=$Produit-> getDateExpiration();
        $categorie=$Produit->getQuantite();
        $prix=$Produit->getPrix();
        $description=$Produit->getDescription();

        $image=$Produit->getImage();

        $enseigne=$Produit->getIdenseignepromo()->getNom();



        return $this->render('ClientBundle:client:voirplusPromo.html.twig',array('id'=>$id,'ref'=>$reference,'nom'=>$nom,'cat'=>$categorie,'p'=>$prix,'des'=>$description,'img'=>$image,'e'=>$enseigne));



    }


    public function BoutiqueEnseigneAction(Request $request)
    {



        $enseigne= new Enseigne();
        $em = $this->getDoctrine()->getManager();

        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();


        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Enseigne p
    WHERE p.categorie =:h'
        );
        $query->setParameter('h',"boutique");
        $enseignes = $query->getResult();


        return $this->render('ClientBundle:client:BoutiqueEnseigne.html.twig',array('enseignes'=>$enseignes));

    }


    public function RestaurantEnseigneAction(Request $request)
    {



        $enseigne= new Enseigne();
        $em = $this->getDoctrine()->getManager();

        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();


        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Enseigne p
    WHERE p.categorie =:h'
        );
        $query->setParameter('h',"restaurant");
        $enseignes = $query->getResult();


        return $this->render('ClientBundle:client:RestaurantEnseigne.html.twig',array('enseignes'=>$enseignes));

    }
    public function chercherpromotionClientAction(Request $request)
    {
        $criteria=$request->get('search');
        $em=$this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT p
    FROM ClientBundle:Promotion p WHERE 
    p.nom LIKE :word OR p.description LIKE :word1 '
        );
        // $query->setParameter('d', $request->get('date'));
        $query->setParameter('word', '%'.$criteria.'%');
        $query->setParameter('word1', '%'.$criteria.'%');




        $promotions = $query->getResult();
       // $promotions=$em->getRepository("ClientBundle:Promotion")->findBy(array('nom'=>$criteria));
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();
        return $this->render('ClientBundle:client:promoClient.html.twig',array('promotions'=>$promotions,'enseignes'=>$enseignes
        )); }

}