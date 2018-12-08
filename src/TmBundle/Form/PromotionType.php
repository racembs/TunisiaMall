<?php

namespace TmBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ClientBundle\Entity\Promotion;
use TmBundle\TmBundle;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Validator\Constraints\File;
use ClientBundle\Entity\Enseigne;
use Symfony\Component\Form\FormTypeInterface;

class PromotionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('description')
                ->add('prix' ,NumberType::class)->add('dateExpiration')
                ->add('quantite')
            ->add('image', FileType::class,array('data_class'=>null))
            ->add('idenseignepromo',EntityType::class,array('class'=>'ClientBundle:Enseigne','choice_label'=>'nom',
                    'multiple'=>false,'required' => true))
                ->add('valider',SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientBundle\Entity\Promotion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tmbundle_promotion';
    }



}
