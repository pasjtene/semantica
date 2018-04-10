<?php

namespace Web\EntityBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommitHistoricType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commit',EntityType::class,array(
                'class'=>"EntityBundle:Commit",
                'property'=>'code',
                'required'=>true,
                'multiple'=>false,
                'translation_domain' => 'forms',
                'empty_data'=>null
            )) // 'empty_value'=>'form.base.empty_commit',
            ->add('project',EntityType::class,array(
            'class'=>"EntityBundle:Projet",
            'property'=>'firstname',
            'required'=>true,
            'multiple'=>false,
            'translation_domain' => 'forms',
            'empty_data'=>null
        )) // 'empty_value'=>'form.base.empty_project',
            ->add('task',EntityType::class,array(
            'class'=>"EntityBundle:Task",
            'property'=>'identity',
            'required'=>true,
            'multiple'=>false,
            'translation_domain' => 'forms',
            'empty_data'=>null
        )); //  'empty_value'=>'form.base.empty_task',
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Web\EntityBundle\Entity\CommitHistoric'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_commithistoric';
    }


}
