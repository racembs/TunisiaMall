<?php

namespace TmBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use ClientBundle\Entity\Enseigne;
use ClientBundle\Entity\Produit;
use TmBundle\TmBundle;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('reference')->add('nom')->add('categorie', ChoiceType::class, array(
            'choices' => array(
                'Femme' => 'Femme',
                'Homme' => 'Homme',
                'Enfant' => 'Enfant',
                'Accessoires' => 'Accessoires'

            )))->add('prix')->add('quantite')->add('description')->add('promo')->add('image', FileType::class, array('data_class'=>null))
       ->add('idenseigne',EntityType::class,array('class'=>'ClientBundle:Enseigne','choice_label'=>'nom','multiple'=>false,))  ->add('valider', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tmbundle_produit';
    }


}
