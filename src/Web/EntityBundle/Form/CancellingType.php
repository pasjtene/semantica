<?php

namespace Web\EntityBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CancellingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('addcode',TextType::class,array(
                'label' => 'form.commit.addcode',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('adddescription',TextareaType::class,array(
                'label' => 'form.commit.adddescription',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('adddate',DateTimeType::class,array(
                'label' => 'form.commit.adddate',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('code',TextType::class,array(
                'label' => 'form.commit.code',
                'translation_domain' => 'forms',
                'required'    => true
            ))
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
            ->add('participator',EntityType::class,array(
            'class'=>"EntityBundle:Participator",
            'property'=>'code',
            'required'=>true,
            'multiple'=>false,
            'empty_value'=>'form.base.empty_participator',
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
            'data_class' => 'Web\EntityBundle\Entity\Cancelling'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_cancelling';
    }


}
