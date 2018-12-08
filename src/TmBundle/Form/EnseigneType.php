<?php

namespace TmBundle\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ClientBundle\Entity\User;

class EnseigneType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom')
            ->add('description')
            ->add('categorie')
            ->add('capacitemax')
            ->add('capacite')
            ->add('pourcentagefidalite')
            ->add('image',FileType::class,array('data_class'=>null))

           ->add('idproprietaire',EntityType::class,array(
               'class'=> 'ClientBundle:User',
               'choice_label'=> 'id',
               'multiple' =>false,
           ))

            ->add('save',SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tmbundle_enseigne_form';
    }


}
