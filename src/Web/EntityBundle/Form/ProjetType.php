<?php

namespace Web\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
        $builder->add('name',TextType::class,array(
            'label' => 'form.project.name',
            'attr'=>['placeholder'=>'form.project.placeholder_name'],
            'translation_domain' => 'forms',
            'required'    => false
        ))
            ->add('email',EmailType::class,array(
                'label' => 'form.project.email',
                'attr'=>['placeholder'=>'form.project.placeholder_email'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('phone',TextType::class,array(
                'label' => 'form.project.phone',
                'attr'=>['placeholder'=>'form.project.placeholder_phones'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('objet',TextType::class,array(
                'label' => 'form.project.objet',
                'attr'=>['placeholder'=>'form.project.placeholder_objet'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('description',TextareaType::class, array(
                'label' => 'form.project.description',
                'attr' => ['class' => 'materialize-textarea', 'placeholder'=>'form.project.placeholder_description'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('adress',TextType::class,array(
                'label' => 'form.project.adress',
                'attr'=>['placeholder'=>'form.project.placeholder_adress'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('country',TextType::class,array(
                'label' => 'form.project.country',
                'attr'=>['placeholder'=>'form.project.placeholder_country'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('city',TextType::class,array(
                'label' => 'form.project.city',
                'attr'=>['placeholder'=>'form.project.placeholder_city'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('type',TextType::class,array(
                'label' => 'form.project.type',
                'attr'=>['placeholder'=>'form.project.placeholder_type'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('file',FileType::class,array(
                'label' => 'form.project.file',
                'attr'=>['placeholder'=>'form.project.placeholder_file','accept'=>".pdf"],
                'translation_domain' => 'forms',
                'required'    => false
            ));
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
