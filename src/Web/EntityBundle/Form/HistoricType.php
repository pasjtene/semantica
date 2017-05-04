<?php

namespace Web\EntityBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoricType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startdate',DateTimeType::class,array(
                'label' => 'form.historic.startdate',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('enddate',DateTimeType::class,array(
                'label' => 'form.historic.endate',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('project',EntityType::class,array(
                'class'=>"EntityBundle:Projet",
                'property'=>'firstname',
                'required'=>true,
                'multiple'=>false,
                'empty_value'=>'form.base.empty_project',
                'translation_domain' => 'forms',
                'empty_data'=>null
            ))
            ->add('roles',TextareaType::class,array(
                'label' => 'form.historic.date',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('participator',EntityType::class,array(
                'class'=>"EntityBundle:Participator",
                'property'=>'firstname',
                'required'=>true,
                'multiple'=>false,
                'empty_value'=>'form.base.empty_participator',
                'translation_domain' => 'forms',
                'empty_data'=>null
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Web\EntityBundle\Entity\Historic'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_historic';
    }


}
