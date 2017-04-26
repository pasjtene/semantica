<?php

namespace Web\EntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname',TextType::class,array(
            'label' => 'form.user.firstname',
            'attr'=>['placeholder'=>'form.user.placeholder_firstname'],
            'translation_domain' => 'forms',
            'required'    => true
        ))
            ->add('lastname',TextType::class,array(
                'label' => 'form.user.lastname',
                'attr'=>['placeholder'=>'form.user.placeholder_lastname'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('country',TextType::class,array(
                'label' => 'form.user.country',
                'attr'=>['placeholder'=>'form.user.placeholder_country'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('sex',TextType::class,array(
                'label' => 'form.user.sex',
                'attr'=>['placeholder'=>'form.user.placeholder_sex'],
                'translation_domain' => 'forms',
                'required'    => false
            ))
            ->add('password',PasswordType::class,array(
                'label' => 'form.user.password',
                'attr'=>['placeholder'=>'form.user.placeholder_password'],
                'translation_domain' => 'forms',
                'required'    => true
            ))
            ->add('email',TextType::class,array(
                'label' => 'form.user.email',
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
