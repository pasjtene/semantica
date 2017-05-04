<?php

namespace Web\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           $builder->add('firstname',TextType::class,array(
               'label' => 'form.person.firstname',
               'translation_domain' => 'forms',
               'required'    => true
           ))
               ->add('lastname',TextType::class,array(
                   'label' => 'form.person.lastname',
                   'translation_domain' => 'forms',
                   'required'    => false
               ))
               ->add('country',TextType::class,array(
                   'label' => 'form.person.country',
                   'translation_domain' => 'forms',
                   'required'    => false
               ))
               ->add('city',TextType::class,array(
                   'label' => 'form.person.city',
                   'translation_domain' => 'forms',
                   'required'    => false
               ))
               ->add('pleasantries',ChoiceType::class,array(
                   'label' => 'form.person.pleasantries',
                   'choices'=>array('form.person.profesor'=>'form.person.profesor','form.person.doctor'=>'form.person.doctor','form.person.mister'=>'form.person.mister','form.user.missis'=>'form.person.missis'),
                   'multiple'=>false,
                   'empty_value'=>'form.person.placeholder_pleasantries',
                   'empty_data'=>null,
                   'translation_domain' => 'forms',
                   'required'    => false
               ))
               ->add('ip',TextType::class,array(
                   'label' => 'form.visitor.ip',
                   'translation_domain' => 'forms',
                   'required'    => true
               ))
               ->add('email',TextType::class,array(
                   'label' => 'form.person.email',
                   'translation_domain' => 'forms',
                   'required'    => true
               ))

               ->add('phone',TextType::class,array(
                   'label' => 'form.person.phone',
                   'translation_domain' => 'forms',
                   'required'    => true
               ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Web\EntityBundle\Entity\Visitor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_visitor';
    }


}
