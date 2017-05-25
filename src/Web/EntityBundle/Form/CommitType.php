<?php

namespace Web\EntityBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',TextType::class,array(
                'label' => 'form.commit.code',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('description',TextareaType::class,array(
                'label' => 'form.person.description',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('date',DateTimeType::class,array(
                'label' => 'form.person.date',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('user',EntityType::class,array(
                'class'=>"EntityBundle:User",
                'property'=>'firstname',
                'required'=>true,
                'multiple'=>false,
                'translation_domain' => 'forms',
                'empty_data'=>null
            ))
            ->add('participator',EntityType::class,array(
                'class'=>"EntityBundle:Participator",
                'property'=>'code',
                'required'=>true,
                'multiple'=>false,
                'translation_domain' => 'forms',
                'empty_data'=>null
            )); //'empty_value'=>'form.base.empty_participator',
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Web\EntityBundle\Entity\Commit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_commit';
    }


}
