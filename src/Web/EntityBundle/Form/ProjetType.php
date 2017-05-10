<?php

namespace Web\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title',TextType::class,array(
            'label' => 'form.project.title',
            'attr'=>['placeholder'=>'form.project.placeholder_title'],
            'translation_domain' => 'forms',
            'required'    => false
        ))

            ->add('company',TextType::class,array(
                'label' => 'form.project.company',
                'attr'=>['placeholder'=>'form.project.placeholder_company'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('description',TextareaType::class, array(
                'label' => 'form.project.description',
                'attr' => ['class' => 'materialize-textarea', 'placeholder'=>'form.project.placeholder_description'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('file',FileType::class,array(
                'label' => 'form.project.file',
                'attr'=>['placeholder'=>'form.project.placeholder_file','accept'=>".pdf,.docs,.doc"],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('user',UserType::class
            );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Web\EntityBundle\Entity\Projet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_projet';
    }


}
