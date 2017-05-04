<?php

namespace Web\EntityBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description',TextareaType::class,array(
                'label' => 'form.base.description',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('date',DateTimeType::class,array(
                'label' => 'form.base.date',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('project',EntityType::class,array(
                'class'=>"EntityBundle:Projet",
                'property'=>'title',
                'required'=>true,
                'multiple'=>false,
                'empty_value'=>'form.base.empty_project',
                'translation_domain' => 'forms',
                'empty_data'=>null
            ))
            ->add('task',EntityType::class,array(
                'class'=>"EntityBundle:Task",
                'property'=>'identity',
                'required'=>true,
                'multiple'=>false,
                'empty_value'=>'form.base.empty_task',
                'translation_domain' => 'forms',
                'empty_data'=>null
            ))
            ->add('user',EntityType::class,array(
                'class'=>"EntityBundle:User",
                'property'=>'firstname',
                'required'=>true,
                'multiple'=>false,
                'empty_value'=>'form.base.empty_user',
                'translation_domain' => 'forms',
                'empty_data'=>null
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Web\EntityBundle\Entity\Comment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_comment';
    }


}
