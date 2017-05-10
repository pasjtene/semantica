<?php

namespace Web\EntityBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReplyType extends AbstractType
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
            ->add('comment',EntityType::class,array(
                'class'=>"EntityBundle:Comment",
                'property'=>'decription',
                'required'=>true,
                'multiple'=>false,

                'translation_domain' => 'forms',
                'empty_data'=>null
            )) //'empty_value'=>'form.base.empty_comment',
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
            'data_class' => 'Web\EntityBundle\Entity\Reply'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_reply';
    }


}
