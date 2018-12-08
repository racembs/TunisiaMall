<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 06/11/2017
 * Time: 15:42
 */

namespace TmBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Produit;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TmBundle\Form\ProduitType;
use TmBundle\Form\UserType;
use TmBundle\Form\PromotionType;
use ClientBundle\Entity\Promotion;
use ClientBundle\Entity\User;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

class TmController extends Controller
{
    public function homeAction()
    {
        return $this->render('TmBundle:tmtm:index.html.twig');
    }
    public function loginAction()
    {
        return $this->render('TmBundle:tmtm:login.html.twig');
    }
      /*Promotions*//////////////////////////////////////////////////////////////////////////////////////////
    public function promoAction(Request $request)
    {
        $datej=new \DateTime('now');
        $em = $this->getDoctrine()->getManager();
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();
        $promotions=$em->getRepository("ClientBundle:Promotion")->findAll();
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class,$promotion);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $promotion->setDateCreation($datej);
            $dir = "C:\\wamp\\www\\TMpi\\web\\images";
            $file = $form['image']->getData();
            $promotion->setImage($promotion->getNom() . ".png");
            $file->move($dir, $promotion->getImage());
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();
            $promotion = $form->getData();

            if ($promotion->getDateExpiration() > $datej) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($promotion);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'ajoutée avec succés'
                );
                return $this->redirect($this->generateUrl('tm_promotion', array('id' => $promotion->getId(),'x'=>2)));
            } else
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'date invalide la date d expiration doit etre superieure a la date de jour'
                );
        }
        return $this->render("TmBundle:tmtm:promo.html.twig", array(
            'promotion' => $promotion,
            'form'=>$form->createView(),'promotions'=>$promotions,'enseignes'=>$enseignes
        ));
    }
    public function promoSearchAction(Request $request)
    {
        $criteria=$request->get('srchpro');
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
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();
        return $this->render("TmBundle:tmtm:promoSearch.html.twig",array('promotionsF'=>$promotions,'enseignes'=>$enseignes));
    }
    public function promosupprimerAction(Request $request)
    { $id=$request->get('id');
        //creer une instance de l'entity manager
        $em=$this->getDoctrine()->getManager();
        $promotion=$em->getRepository("ClientBundle:Promotion")->find($id);
        $em->remove($promotion);
        $em->flush();
        return $this->redirectToRoute("tm_promotion");
    }
    public function promoajouterAction(Request $request)
    {
        $datej=new \DateTime('now');
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class,$promotion);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $dir="C:\\wamp\\www\\TMpi\\web\\images";
            $file = $form['image']->getData();
            $promotion->setDateCreation($datej);
            $promotion->setImage($promotion->getId().".png");


            $file->move($dir, $promotion->getImage());
            /*
           $dir="D:\\wamp64\\www\\TMpi\\web\\images";

           $file = $Form['image']->getData();
           $produit1->setImage($produit1->getReference().".png");

           $file->move($dir, $produit1->getImage());*/

            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();
            return $this->redirect($this->generateUrl('tm_homepage'));
        }
        return $this->render('TmBundle:tmtm:ajouterPromo.html.twig', array(
            'promotion' => $promotion,
            'form'   => $form->createView(),

        ));
    }

    public function promoModifierAction(Request $request)
    { $id=$request->get('id');
        //creer une instance de l'entity manager
        $em = $this->getDoctrine()->getManager();
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();
        $promotions=$em->getRepository("ClientBundle:Promotion")->findAll();
        $promotion=$em->getRepository("ClientBundle:Promotion")->find($id);
        $img=$promotion->getImage();
        $form = $this->createForm(PromotionType::class,$promotion);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dir="C:\\wamp\\www\\TMpi\\web\\images";
            $file = $form['image']->getData();
            $promotion->setImage($promotion->getId().$promotion->getNom().".png");


            $file->move($dir, $promotion->getImage());
          //  $em->persist($promotion);
            $em->flush();
            return $this->redirect($this->generateUrl('tm_promotion'));
        }
        return $this->render('TmBundle:tmtm:modifierPromo.html.twig', array('form'   => $form->createView(),'promotions'=>$promotions,'enseignes'=>$enseignes,
            'img'=>$img        ));

    }

//////////////////////////////////////////////////////////////////////////////////////
    public function enseigneAction()
    {
        //creer une instance de l'entity manager
        $em=$this->getDoctrine()->getManager();
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();
        return $this->render("TmBundle:tmtm:enseigne.html.twig",array('enseignes'=>$enseignes));
    }


    public function clientAction(Request $request)
    {

         $em=$this->getDoctrine()->getManager();


       $query = $em->createQuery('SELECT u FROM ClientBundle:User u WHERE u.roles LIKE :role')
            ->setParameter('role',"%ROLE_USER%");

        $client = $query->getResult();
        $etat="";
        if($request->isMethod("POST")){

            $key=$request->get("search");

           $client=$em->getRepository("ClientBundle:User")->findBy(array("nom"=>$key));
            if(empty($client)){
                $key=$request->get("search");

                $client=$em->getRepository("ClientBundle:User")->findBy(array("prenom"=>$key));
            }
            if(empty($client)){
                $key=$request->get("search");

                $client=$em->getRepository("ClientBundle:User")->findBy(array("email"=>$key));
            }
            if(empty($client)){
                $key=$request->get("search");

                $client=$em->getRepository("ClientBundle:User")->findBy(array("username"=>$key));
            }
            if(empty($client)){
                $key=$request->get("search");

                $client=$em->getRepository("ClientBundle:User")->findBy(array("cin"=>$key));
            }
        }

        if(empty($client)){
            $query = $em->createQuery('SELECT u FROM ClientBundle:User u WHERE u.roles LIKE :role')
                ->setParameter('role',"%ROLE_USER%");
            $client = $query->getResult();
            $etat="Client n'existe pas :(";
        }


        return $this->render('TmBundle:tmtm:client.html.twig',array("clients"=>$client,"etat"=>$etat));

    }

    public function modifClientAction(Request $request)
    {

        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $Modele=$em->getRepository("ClientBundle:User")->find($id);
        $form=$this->createForm(UserType::class,$Modele);
        $form->handleRequest($request);
        if($form->isValid()){

            $em->persist($Modele);
            $em->flush();
            return  $this->redirectToRoute("tm_client");
               }
        return $this->render('TmBundle:tmtm:modifclient.html.twig',array("Form"=>$form->createView())
        );

    }



    public function offreEmpAction()
    {
        return $this->render('TmBundle:tmtm:login.html.twig');
    }
    public function commandeAction()
    {     $em=$this->getDoctrine()->getManager();
        $commande=$em->getRepository("ClientBundle:Commande")->findAll();

        return $this->render('TmBundle:tmtm:Commande.html.twig',array("commande"=>$commande));

    }



    public function produitAction(Request $request)
    {
        $datej=new \DateTime('now');
        $em=$this->getDoctrine()->getManager();
        $produits=$em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();
        $produit1=new Produit();
        $Form=$this->createForm(ProduitType::class,$produit1);
        $Form->handleRequest($request);
        if ($Form->isValid())

        { $produit1->setDate($datej);
            $dir="C:\\wamp\\www\\TMpi\\web\\images";

            $file = $Form['image']->getData();
            $produit1->setImage($produit1->getReference().".png");

            $file->move($dir, $produit1->getImage());





            $em= $this->getDoctrine()->getManager();
            $em->persist($produit1);
            $em->flush();
            return $this->redirectToRoute('tm_produit');

        }



        return $this->render('TmBundle:tmtm:produit.html.twig',array(
            "Form"=>$Form->createView(),'produits'=>$produits,'enseignes'=>$enseignes));
    }

    public function deleteProduitAction(Request $request)
    {
        $id=$request->get('id');
        $em= $this->getDoctrine()->getManager();
        $Produit=$em->getRepository('ClientBundle:Produit')->find($id);
        $em->remove($Produit);
        $em->flush();
        return $this->redirectToRoute("tm_produit");
    }



    public function modifierProduitAction(Request $request)
    {
        $id=$request->get('id');
        $em= $this->getDoctrine()->getManager();
        $produits=$em->getRepository("ClientBundle:Produit")->findAll();
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();
        $Produit=$em->getRepository('ClientBundle:Produit')->find($id);
        $form=$this->createForm(ProduitType::class,$Produit);
        $form->handleRequest($request);
        $img=$Produit->getImage();
        if ($form->isValid())
        {
            $dir="C:\\wamp64\\www\\TMpi\\web\\images";

            $file = $form['image']->getData();
            $Produit->setImage($Produit->getReference().".png");

            $file->move($dir, $Produit->getImage());
            $em->persist($Produit);
            $em->flush();
            return $this->redirect( $this->generateUrl("tm_produit"));

        }
        return $this->render('TmBundle:tmtm:modifierProduit.html.twig',array(
            "form"=>$form->createView(),"img"=>$img,'produits'=>$produits,'enseignes'=>$enseignes
        ));
    }

    public function AjoutProduitAction(Request $request)
    {
        $produit=new Produit();
        $Form=$this->createForm(ProduitType::class,$produit);
        $Form->handleRequest($request);
        if ($Form->isValid())

        {



            $em= $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('tm_produit');


        }


        return $this->render('TmBundle:tmtm:produit.html.twig',array(
            "Form"=>$Form->createView()
        ));

    }



    public function produitSearchAction(Request $request)
    {
        $criteria=$request->get('srchpro');
        $em=$this->getDoctrine()->getManager();
        $produitF=$em->getRepository("ClientBundle:Produit")->findBy(array('nom'=>$criteria));
        $enseignes=$em->getRepository("ClientBundle:Enseigne")->findAll();
        return $this->render("TmBundle:tmtm:produitSearch.html.twig",array('produits'=>$produitF,'enseignes'=>$enseignes));
    }
    public function affichecommandeAction(Request $request)
    {
        $id=$request->get( 'id');
        $em= $this->getDoctrine()->getManager();

        $Lignecommande=$em->getRepository("ClientBundle:Lignecommande")->findBy(array("idcommande"=>$id));
        return $this->render('TmBundle:tmtm:affichecommande.html.twig',array("lignecommande"=>$Lignecommande));
    }
    public function retournerAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $etat=1;
        $commande=$em->getRepository("ClientBundle:Commande")->findBy(array("etat"=>$etat));

        return $this->render('TmBundle:tmtm:Commande.html.twig',array("commande"=>$commande));
    }
    public function commandesearchAction(Request $request)

    {$em=$this->getDoctrine()->getManager();
   if($request->isMethod("POST")){
       $query = $em->createQuery(
           'SELECT p
    FROM ClientBundle:Commande p
    WHERE p.date =:d '
       );
       $query->setParameter('d',$request->get("search"));

       $commande= $query->getResult();

}

        return $this->render('TmBundle:tmtm:Commande.html.twig',array("commande"=>$commande));
    }

    public function commandesearchuserAction(Request $request)

    {$em=$this->getDoctrine()->getManager();
        if($request->isMethod("POST")){
            $query = $em->createQuery(
                'SELECT p
    FROM ClientBundle:Commande p
    WHERE p.ville =:d '
            );
            $query->setParameter('d',$request->get("search"));

            $commande= $query->getResult();

        }

        return $this->render('TmBundle:tmtm:Commande.html.twig',array("commande"=>$commande));
    }


    public function StatistiquesAction(Request $request)
    {

        $em = $this->container->get('doctrine')->getEntityManager();
        $produits = $em->getRepository("ClientBundle:Produit")->findAll();
        $tab = array();
        $categories = array();

        $nbF=0;
        $nbH=0;
        $nbE=0;
        $nbA=0;
        foreach ($produits as $pd) {
            if($pd->getCategorie()=="Femme")
            {
                $nbF=$nbF+$pd->getNbjaimes();

                array_push($categories, "Femme");
            }
            if($pd->getCategorie()=="Homme")
            {
                $nbH=$nbH+$pd->getNbjaimes();

                array_push($categories, "Homme");
            }

            if($pd->getCategorie()=="Enfant")
            {
                $nbE=$nbE+$pd->getNbjaimes();

                array_push($categories, "Enfant");
            }

            if($pd->getCategorie()=="Accessoires")
            {
                $nbA=$nbA+$pd->getNbjaimes();

                array_push($categories,"Accessoires");
            }

        }

        array_push($tab, $nbF);
        array_push($tab, $nbH);
        array_push($tab, $nbE);
        array_push($tab, $nbA);

        // Chart
        $series = array(
            array("name" => "Nb J'aimes", "data" => $tab)
        );
        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  //  #id du div où afficher le graphe
        $ob->title->text('Nombre de Jaimes');
        $ob->xAxis->title(array('text' => "Categorie"));
        $ob->yAxis->title(array('text' => "Nb Jaimes"));
        $ob->xAxis->categories($categories);
        $ob->series($series);







        $carte = $em->getRepository("ClientBundle:Cartefedalite")->findAll();




        $c1=0;
        $c2=0;
        $c3=0;

        foreach ($carte as $c) {
            if($c->getType()=="gold")
            {
                $c1=$c1+($c->getTotale());


            }
            if($c->getType()=="premium")
            {
                $c2=$c2+($c->getTotale());
            }

            if($c->getType()=="basic")
            {
                $c3=$c3+($c->getTotale());
            }



        }









        $ob1 = new Highchart();
        $ob1->chart->renderTo('piechart');
        $ob1->title->text('Pourcentages des Cartes de fidélités');
        $ob1->plotOptions->pie(array(
            'allowPointSelect' => true,
            'cursor' => 'pointer',
            'dataLabels' => array('enabled' => false),
            'showInLegend' => true
        ));


        $total = 0;
        foreach ( $carte as $classe) {
            $total = $classe->getTotale()+$total;
        }




        $data = array();
        $i=0;
        $stat1 = array();
        $stat2 = array();
        $stat3 = array();



        $c1=$c1/$total;
        $c2=$c2/$total;
        $c3=$c3/$total;
        array_push($stat1, "Gold", $c1);
        //var_dump($stat);


        array_push($data, $stat1);



        array_push($stat2, "Premium", $c2);
        //var_dump($stat);


        array_push($data, $stat2);


        array_push($stat3, "Basic", $c3);
        //var_dump($stat);


        array_push($data, $stat3);





        // var_dump($data);
        $ob1->series(array(array('type' => 'pie', 'name' => 'Browser share', 'data' => $data)));





        $classesP = $em->getRepository('ClientBundle:Produit')->findAll();
        $classesE = $em->getRepository('ClientBundle:Enseigne')->findAll();
        $classesPro = $em->getRepository('ClientBundle:Promotion')->findAll();
        $classesOffres = $em->getRepository('ClientBundle:Offresemplois')->findAll();
        $classesC = $em->getRepository('ClientBundle:Commande')->findAll();

        $totalP = 0;
        $totalE = 0;
        $totalPro = 0;
        $totalOffres=0;
        $totalC=0;

        foreach ($classesP as $classe) {
            $totalP = $totalP + 1;
        }

        foreach ($classesE as $classe) {
            $totalE = $totalE + 1;
        }

        foreach ($classesPro as $classe) {
            $totalPro = $totalPro + 1;
        }

        foreach ($classesOffres as $classe) {
            $totalOffres = $totalOffres + 1;
        }

        foreach ($classesC as $classe) {
            $totalC = $totalC + 1;
        }






        $categories = array("Produits","Enseignes","Promotions","Offres dEmplois","Commandes");
        $nb = array($totalP,$totalE,$totalPro,$totalOffres,$totalC );

        $series = array(
            array(
                'name' => 'Etudiant',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nb,
            )
        );
        $yData = array(

            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + "" }'),
                    'style' => array('color' => '#4572A7')
                ),
                'gridLineWidth' => 0,
                'title' => array(
                    'text' => 'Effectif',
                    'style' => array('color' => '#4572A7')
                ),
            ),
        );

        $ob2 = new Highchart();
        $ob2->chart->renderTo('container'); // The #id of the div where to render the chart
        $ob2->chart->type('column');
        $ob2->title->text('Effectif ');

        $ob2->xAxis->categories($categories);
        $ob2->yAxis($yData);

        $ob2->legend->enabled(false);
        $formatter = new Expr('function () { 
var unit = {                   
                    "Produits": "Produit(s)",              
                    }[this.series.name];           
                    return this.x + ": <b>" + this.y + "</b> " + unit;  
                    }');
        $ob2->tooltip->formatter($formatter);
        $ob2->series($series);





        return $this->render('TmBundle:tmtm:LineChart.html.twig',
            array(
                'chart1' => $ob,'nbF'=>$nbF,'nbH'=>$nbH,'nbE'=>$nbE,'nbA'=>$nbA,'chart3' => $ob1, 'chart2' => $ob2
            ));
    }
    public function chercherpromoajaxAction(Request $request)
    {
        $promotion=new Promotion();
        $em=$this->getDoctrine()->getManager();
        $promotions=$em->getRepository("ClientBundle:Promotion")->findAll();
        if($request->isXmlHttpRequest()){
            $serializer=new Serializer(array(new ObjectNormalizer()));
            $promotions=$em->getRepository('TmBundle:Promotion')
                ->findBy(array('nom'=>get('serie')));
            $data=$serializer->normalize($promotions);
            return new JsonResponse($data);}
            return $this->render("TmBundle:tmtm:promo.html.twig",array(
                'promotion' => $promotion));


        }



}