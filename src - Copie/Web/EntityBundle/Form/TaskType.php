<?php

namespace Web\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identity',TextType::class,array(
                'label' => 'form.task.identity',
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('libelle',TextType::class,array(
                'label' => 'form.task.libelle',
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
            ->add('planning');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Web\EntityBundle\Entity\Task'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_task';
    }


}
