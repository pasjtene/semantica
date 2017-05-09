<?php

namespace Web\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname',TextType::class,array(
            'label' => 'form.person.firstname',
            'attr'=>['placeholder'=>'form.user.placeholder_firstname'],
            'translation_domain' => 'forms',
            'required'    => true
        ))
            ->add('lastname',TextType::class,array(
                'label' => 'form.person.lastname',
                'attr'=>['placeholder'=>'form.user.placeholder_lastname'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('country',TextType::class,array(
                'label' => 'form.person.country',
                'attr'=>['placeholder'=>'form.user.placeholder_country'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('pleasantries',ChoiceType::class,array(
                'label' => 'form.person.pleasantries',
                'choices'=>array('form.person.profesor'=>'form.person.profesor','form.person.doctor'=>'form.person.doctor','form.person.mister'=>'form.person.mister','form.user.missis'=>'form.person.missis'),
                'multiple'=>false,
                'empty_data'=>null,
                'translation_domain' => 'forms',
                'required'    => false
            )) //  'empty_value'=>'form.person.placeholder_pleasantries',
            ->add('password',PasswordType::class,array(
                'label' => 'form.user.password',
                'attr'=>['placeholder'=>'form.user.placeholder_password'],
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('email',EmailType::class,array(
                'label' => 'form.person.email',
                'attr'=>['placeholder'=>'form.user.placeholder_email'],
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('username',TextType::class,array(
                'label' => 'form.user.username',
                'attr'=>['placeholder'=>'form.user.placeholder_username'],
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('city',TextType::class,array(
                'label' => 'form.person.city',
                'attr'=>['placeholder'=>'form.user.placeholder_username'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
    ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Web\EntityBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'web_entitybundle_user';
    }


}
