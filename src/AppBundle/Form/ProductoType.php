<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoType extends AbstractType
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
            ->add('descripcion','textarea', array(
                'label' => false,
                'attr'=>array(
                    'placeholder' => 'Descripción de la tienda',
                    'class'=>'form-control',
                ),
            ))
            ->add('categoria', 'choice', array(
                'choices' => array('' => 'Elija una categoría', 'informatica'=> 'Informática', 'moda'=>'Moda'),
                'label' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('precio', 'number', array(
                'label' => false,
                'attr'=>array(
                    'placeholder' => 'Precio',
                    'class'=>'form-control',
                    'min'=>'0',
                    'invalid_message' => 'Debes de introducir numeros',
                ),
            ))
            ->add('cantidad', 'integer' , array(
                'label' => false,
                'attr'=>array(
                    'placeholder' => 'Cantidad',
                    'class'=>'form-control',
                    'min'=>'0'
                ),
            ))
            ->add('peso', 'number', array(
                'label' => false,
                'attr'=>array(
                    'placeholder' => 'Peso',
                    'class'=>'form-control',
                    'min'=>'0'
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Producto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_producto';
    }
}
