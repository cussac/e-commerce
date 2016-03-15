<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PerfilType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text',array(
                'label' => false,
                'attr'  => array(
                    'placeholder' => 'Nombre',
                    'class'=>'form-control',
                ),
            ))
            ->add('apellido1','text',array(
                'label' => false,
                'attr'  => array(
                    'placeholder' => 'Primer apellido',
                    'class'=>'form-control',
                ),
            ))
            ->add('apellido2','text',array(
                'label' => false,
                'required'=> false,
                'attr'  => array(
                    'placeholder' => 'Segundo apellido',
                    'class'=>'form-control',
                ),
            ))
            ->add('email','email',array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Correo electrónico',
                    'class' => 'form-control',
                ),
            ))
            ->add('username','text',array(
                'label' => false,
                'attr'  => array(
                    'placeholder'=>'Nombre de usuario',
                    'class'=>'form-control',
                ),
            ))
            ->add('password', 'repeated', array(
                'label'          => false,
                'type'           => 'text',
                'invalid_message'=> 'Las contraseñas no coinciden',
                'options'        => array('attr' => array('class' => 'password-field ', 'id'=>'password')),
                'required'       => true,
                'first_options'  => array(
                    'label' => false,
                    'attr' => array('placeholder'=>'Contraseña', 'class'=>'form-control')
                ),
                'second_options' => array(
                    'label' => false,
                    'attr' => array('placeholder'=>'Repite la contraseña', 'class'=>'form-control')
                ),
            ))
            ->add('terms','checkbox',array(
                    'label' => false,
                    'property_path' => 'termsAccepted',
                    'data' => true
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
}
