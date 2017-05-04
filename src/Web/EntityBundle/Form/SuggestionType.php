<?php

namespace Web\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuggestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        >add('description',TextareaType::class,array(
            'label' => 'form.base.description',
            'translation_domain' => 'forms',
            'required'    => true
        ))
            ->add('date',DateTimeType::class,array(
                'label' => 'form.base.date',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('person',EntityType::class,array(
                'class'=>"EntityBundle:Person",
                'property'=>'firstname',
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
            'data_class' => 'Web\EntityBundle\Entity\Suggestion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_suggestion';
    }


}
