<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 20/11/2017
 * Time: 17:52
 */

namespace ClientBundle\Controller;

use ClientBundle\Entity\Cartefedalite;
use ClientBundle\Entity\Lignecommande;


use Symfony\Component\Validator\Constraints\DateTime;
use ClientBundle\Entity\Produit;
use ClientBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use  ClientBundle\Entity\Commande;
use  ClientBundle\Entity\Paiement;

class PanierController extends Controller
{
    public function ajouterlignecommandeAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();
        if ($request->isMethod("POST")) {

            $quantite = $request->get('quantite');
            $idProduit = $request->get('idProduit');

            $user = $this->getUser();
            $id = $user->getId();
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
            }
            /////////////////////////////////////////////
            if($CMD1->getDate()== $datej=new \DateTime('yesterday'))
            {
                $msg = "";
                $msg1 = "votre panier est supprimer veuillez remplir un autre de nouveau";
                //////////////////////////supprimer la commande




                $Lignecommande = $em->getRepository('ClientBundle:Lignecommande')->findby(array("idcommande" => $CMD1->getId()));
                foreach ($Lignecommande as $x) {
                    $idProduit = $x->getIdproduit();
                    $produit = $em->getRepository("ClientBundle:Produit")->find($idProduit);
                    $quantite = $x->getQuantite();
                    $quantiteproduit = $produit->getQuantite();
                    $qt = $quantiteproduit + $quantite;
                    $produit->setQuantite($qt);
                    $em->persist($produit);
                    $em->flush();
                }
                $em->remove($CMD1);
                $em->flush();

                return $this->render('ClientBundle:client:produit.html.twig', array(
                    'produit' => $produits, 'enseignes' => $enseignes, 'Message' => $msg, 'Message1' => $msg1));

            }
///////////////////////////////////////
            $produit = $em->getRepository("ClientBundle:Produit")->find($idProduit);
            if ($produit->getQuantite() > $quantite) {


                $ligneCMD = new Lignecommande();
                $ligneCMD->setIdproduit($produit);
                $ligneCMD->setIdcommande($CMD1);
                $ligneCMD->setPrix($produit->getPrix());
                $ligneCMD->setQuantite($quantite);
                $promo = $produit->getPromo();
                $prix = $produit->getPrix();
                $total = $prix * $promo * $quantite;

                /////////////////////

                $produit=$em->getRepository("ClientBundle:Produit")->findOneBy(array("id"=>$ligneCMD->getIdproduit()));
                $enseigne=$em->getRepository("ClientBundle:Enseigne")->findOneBy(array("id"=>$produit->getIdenseigne()));
                $totalpts=$prix*$enseigne->getPourcentagefidalite()*5*$quantite;
                $cartesfidelite=$em->getRepository("ClientBundle:Cartefedalite")->findOneBy(array("idenseigne"=>$enseigne->getId(),"idclient"=>$id));
                $cartesfidelite->setNbrpts($cartesfidelite->getNbrpts()+$totalpts);


                $ligneCMD->setTotalpts($totalpts);
                /// ///////////
                $ligneCMD->setPromo($produit->getPromo());
                $ligneCMD->setTotal($total);
                $CMD1->setDate(new \DateTime());

                $quantiteproduit = $produit->getQuantite();
                $qt = $quantiteproduit - $quantite;
                $produit->setQuantite($qt);

                $em->persist($produit);
                $em->persist($ligneCMD);
                $em->flush();
                $msg = 'Votre Produit est ajouter ';
                $msg1 = '';
                return $this->render('ClientBundle:client:produit.html.twig', array(
                    'produit' => $produits, 'enseignes' => $enseignes, 'Message' => $msg, 'Message1' => $msg1));
            } else {
                $msg1 = "la quantite n'est plus disponible";
                $msg = '';
                return $this->render('ClientBundle:client:produit.html.twig', array(
                    'produit' => $produits, 'enseignes' => $enseignes, 'Message' => $msg, 'Message1' => $msg1));
            }

        }
        $msg = "";
        $msg1 = "";

        return $this->render('ClientBundle:client:produit.html.twig', array(
            'produit' => $produits, 'enseignes' => $enseignes, 'Message' => $msg, 'Message1' => $msg1));

    }

    public function panierAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $id = $user->getId();

        $test = 0;
        $commande = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $test));

        if (empty($commande)) {
            $commande = new Commande();
            $commande->setIdclient($user);
            $etat = 0;
            $commande->setEtat($etat);
            $em->persist($commande);
            $em->flush();
        }

        $idcommande = $commande->getId();


        $Lignecommande = $em->getRepository("ClientBundle:Lignecommande")->findBy(array("idcommande" => $idcommande));

        if ($request->isMethod("POST")) {

            $quantite = $request->get('quantite');
            $id = $request->get('input');
            $em = $this->getDoctrine()->getManager();

            $Modele = $em->getRepository("ClientBundle:Lignecommande")->find($id);

            $idProduit =$Modele->getIdproduit();

            /////
            $produit = $em->getRepository("ClientBundle:Produit")->findOneBy(array("id"=>$idProduit ));
            $enseigne = $em->getRepository("ClientBundle:Enseigne")->findOneBy(array("id"=>$produit->getIdenseigne()));
            ////
            $quantit = $Modele->getQuantite();
            $Modele->setQuantite($quantite);
            $prix = $Modele->getPrix();
            $promo = $Modele->getPromo();

            $total = $prix * $promo * $quantite;
            $totalpts = $prix * $enseigne->getPourcentagefidalite() * 5 * $quantit;


            $Modele->setTotal($total);
            $Modele->setTotalpts($totalpts);






            $quantiteproduit = $produit->getQuantite();


            $qt = ($quantiteproduit + $quantit)-$quantite;
            $produit->setQuantite($qt);
            $em->persist($Modele);
            $em->persist($produit);
            $em->flush();




            $msg = 'quantite modifier ';

            return $this->render('ClientBundle:client:panier.html.twig', array("lignecommande" => $Lignecommande, "Message" => $msg));

        }


        $msg = '';

        return $this->render('ClientBundle:client:panier.html.twig', array("lignecommande" => $Lignecommande, "Message" => $msg));

    }

    public function deletelignecommandeAction(Request $request)
    {
        $id1 = $request->get('id');
        $em = $this->getDoctrine()->getManager();

        $lignecommande = $em->getRepository('ClientBundle:Lignecommande')->find($id1);

        $idProduit = $lignecommande->getIdproduit();

        $produit = $em->getRepository("ClientBundle:Produit")->find($idProduit);


        $quantite = $lignecommande->getQuantite();
        $quantiteproduit = $produit->getQuantite();
        $qt = $quantiteproduit + $quantite;
        $produit->setQuantite($qt);


        $em->persist($produit);
        $em->remove($lignecommande);
        $em->flush();


        $user = $this->getUser();
        $id = $user->getId();
        $test = 0;
        $commande = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $test));
        $idcommande = $commande->getId();

        $Lignecommande = $em->getRepository("ClientBundle:Lignecommande")->findBy(array("idcommande" => $idcommande));
        $msg = 'vous avez supprimer la ligne commande';

        return $this->render('ClientBundle:client:panier.html.twig', array("lignecommande" => $Lignecommande, "Message" => $msg));
    }


    public function produitAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes = $em->getRepository("ClientBundle:Enseigne")->findAll();
        if ($request->isMethod("POST")) {

            $quantite = $request->get('quantite');
            $idProduit = $request->get('idProduit');

            $user = $this->getUser();
            $id = $user->getId();
            $etat = 0;
            $user = $em->getRepository("ClientBundle:User")->find($id);

            $CMD1 = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $etat));

            if (empty($CMD1)) {
                $CMD1 = new Commande();
                $CMD1->setIdclient($user);
                $etat = 0;
                $CMD1->setEtat($etat);
                $em->persist($CMD1);
                $em->flush();
            }

            $produit = $em->getRepository("ClientBundle:Produit")->find($idProduit);
            if ($produit->getQuantite() > $quantite) {


                $ligneCMD = new Lignecommande();
                $ligneCMD->setIdproduit($produit);
                $ligneCMD->setIdcommande($CMD1);
                $ligneCMD->setPrix($produit->getPrix());
                $ligneCMD->setQuantite($quantite);
                $promo = $produit->getPromo();
                $prix = $produit->getPrix();
                $total = $prix * $promo * $quantite;
                $ligneCMD->setPromo($produit->getPromo());
                $ligneCMD->setTotal($total);
                $CMD1->setDate(new \DateTime());

                $quantiteproduit = $produit->getQuantite();
                $qt = $quantiteproduit - $quantite;
                $produit->setQuantite($qt);
                //////////////////////////////////////////fidelite/////////////////////

                $produit=$em->getRepository("ClientBundle:Produit")->findOneBy(array("id"=>$ligneCMD->getIdproduit()));
                $enseigne=$em->getRepository("ClientBundle:Enseigne")->findOneBy(array("id"=>$produit->getIdenseigne()));
                $totalpts=$prix*$enseigne->getPourcentagefidalite()*5*$quantite;
                $cartesfidelite=$em->getRepository("ClientBundle:Cartefedalite")->findOneBy(array("idenseigne"=>$enseigne->getId(),"idclient"=>$id));
                $cartesfidelite->setNbrpts($cartesfidelite->getNbrpts()+$totalpts);

                $em->persist($cartesfidelite);
                $em->flush();

                //////////////////////////////////////////////////////////////////////


                $em->persist($produit);
                $em->persist($ligneCMD);
                $em->flush();
                $msg = 'Votre Produit est ajouter ';
                $msg1 = '';
                return $this->render('ClientBundle:client:produit.html.twig', array(
                    'produit' => $produits, 'enseignes' => $enseignes, 'Message' => $msg, 'Message1' => $msg1));
            } else {
                $msg1 = "la quantite n'est plus disponible";
                $msg = '';
                return $this->render('ClientBundle:client:produit.html.twig', array(
                    'produit' => $produits, 'enseignes' => $enseignes, 'Message' => $msg, 'Message1' => $msg1));
            }

        }
        $msg = "";
        $msg1 = "";

        return $this->render('ClientBundle:client:produit.html.twig', array(
            'produit' => $produits, 'enseignes' => $enseignes, 'Message' => $msg, 'Message1' => $msg1));
    }

    public function supprimercommandeAction(Request $request)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $etat = 0;


        $CMD1 = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $etat));
        $Lignecommande = $em->getRepository('ClientBundle:Lignecommande')->findby(array("idcommande" => $CMD1->getId()));
        foreach ($Lignecommande as $x) {
            $idProduit = $x->getIdproduit();
            $produit = $em->getRepository("ClientBundle:Produit")->find($idProduit);
            $quantite = $x->getQuantite();
            $quantiteproduit = $produit->getQuantite();
            $qt = $quantiteproduit + $quantite;
            $produit->setQuantite($qt);
            $em->persist($produit);
            $em->flush();
        }
        $em->remove($CMD1);
        $em->flush();


        $lignecommande = $em->getRepository('ClientBundle:Lignecommande')->findby(array("idcommande" => $CMD1->getId()));


        $msg = 'vous avez supprimer commande';

        return $this->render('ClientBundle:client:panier.html.twig', array("lignecommande" => $lignecommande, "Message" => $msg));
    }

    public function passercommandeAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $id = $user->getId();
        $etat = 0;
        $CMD1 = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $etat));

        if (empty($CMD1)) {

            $CMD1 = new Commande();
            $CMD1->setIdclient($user);
            $etat = 0;
            $CMD1->setEtat($etat);
            $em->persist($CMD1);
            $em->flush();

        }


        $test = 0;
        $commande = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $test));
        $idcommande = $commande->getId();

        $Lignecommande = $em->getRepository("ClientBundle:Lignecommande")->findBy(array("idcommande" => $idcommande));


        $msg = 'vous avez supprimer commande';

        return $this->render('ClientBundle:client:panier.html.twig', array("lignecommande" => $Lignecommande, "Message" => $msg));

    }

    public function paiementAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $id = $user->getId();
        $test = 0;

        $commande = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $test));



        if ($commande->getTotal() == Null) {
            $total = $request->get('total');

            $commande->setTotal($total);
            $em->persist($commande);
            $em->flush();
        }

        if ($request->isMethod("POST")) {
            $adresse = $request->get('adresse');
            $tel = $request->get('tel');
            $ville = $request->get('ville');
            $pays = $request->get('pays');
            $mdp = $request->get('mdp');
            $carte = $request->get('carte');

            $CMD = $em->getRepository("ClientBundle:Paiement")->findOneBy(array('carte' => $carte, 'mdp' => $mdp));


            if (empty($CMD)) {

                $CMD1 = $em->getRepository("ClientBundle:Paiement")->findOneBy(array('carte' => $carte));
                $CMD2 = $em->getRepository("ClientBundle:Paiement")->findOneBy(array('mdp' => $mdp));
                if (empty($CMD1) && empty($CMD2)) {

                    $msg3 = 'veuillez verifier votre mdp et carte ';
                    return $this->render('ClientBundle:client:paiement1.html.twig', array('Message' => $msg3, 'adresse' => $adresse, 'tel' => $tel, 'ville' => $ville, 'pays' => $pays));
                }
                if (empty($CMD1)) {
                    $msg1 = 'veuillez verifier votre carte ';
                    return $this->render('ClientBundle:client:paiement1.html.twig', array('Message' => $msg1, 'adresse' => $adresse, 'tel' => $tel, 'ville' => $ville, 'pays' => $pays));
                }

                if (empty($CMD2)) {
                    $msg2 = 'veuillez verifier vous mdp ';

                    return $this->render('ClientBundle:client:paiement1.html.twig', array('Message' => $msg2, 'adresse' => $adresse, 'tel' => $tel, 'ville' => $ville, 'pays' => $pays));

                }
                $total = $CMD->getTotal();
                $test = 0;
                $commande = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $test));
                $totalpanier = $commande->getTotal();
                if ($total < $totalpanier) {
                    $msg = 'votre Solde est insuffisant ';
                    return $this->render('ClientBundle:client:paiement1.html.twig', array('Message' => $msg, 'adresse' => $adresse, 'tel' => $tel, 'ville' => $ville, 'pays' => $pays));
                }

                return $this->render('ClientBundle:client:paiement.html.twig');
            } else {
                $test = 0;
                $commande = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $test));

                $total = $CMD->getTotal();
                $test = 0;
                $commande = $em->getRepository("ClientBundle:Commande")->findOneBy(array("idclient" => $id, "etat" => $test));
                $totalpanier = $commande->getTotal();
                if ($total < $totalpanier) {
                    $msg = 'votre Solde est insuffisant ';
                    return $this->render('ClientBundle:client:paiement1.html.twig', array('Message' => $msg, 'adresse' => $adresse, 'tel' => $tel, 'ville' => $ville, 'pays' => $pays));
                }
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

                return $this->redirectToRoute('client_homepage');
            }


        }

        $msg = '';
        return $this->render('ClientBundle:client:paiement.html.twig', array('Message' => $msg));
    }
}