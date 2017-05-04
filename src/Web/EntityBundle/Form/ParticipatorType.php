<?php

namespace Web\EntityBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipatorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',TextType::class,array(
                'label' => 'form.participator.code',
                'translation_domain' => 'forms',
                'required'    => true
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
            'data_class' => 'Web\EntityBundle\Entity\Participator'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_participator';
    }


}
