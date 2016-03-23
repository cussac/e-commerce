<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TiendaType extends AbstractType
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
                'choices' => array('' => '-- Elija una categoría --', 'informatica'=> 'Informática', 'moda'=>'Moda', 'cine,tv y musica'=> 'Cine,TV y Música', 'electronica'=> 'Electrónica', 'videojuegos'=> 'Videojuegos',
                                   'juguetes y bebe'=> 'Juguetes y Bebé', 'hogar y jardin'=> 'Hogar y Jardín', 'belleza y salud'=> 'Belleza y Salud', 'ropa y calzado'=> 'Ropa y Calzado', 'deportes y aire libre'=> 'Deportes y Aire Libre',
                                   'motor'=> 'Motor', 'libros'=> 'Libros', 'freak'=> 'Freak', 'otros'=> 'Otros'),
                'label' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('file','file',array(
                'label' => false,
                'required'=> false,
                'attr'  => array(
                    'placeholder'=>'Foto portada de la tienda',
                    'class'=>'form-control',
                ),
            ))
            ->add('facebook','text',array(
                'label' => false,
                'required'=> false,
                'attr'  => array(
                    'placeholder' => 'facebook',
                    'class'=>'form-control',
                ),
            ))
            ->add('twitter','text',array(
                'label' => false,
                'required'=> false,
                'attr'  => array(
                    'placeholder' => 'twitter',
                    'class'=>'form-control',
                ),
            ))
            ->add('instagram','text',array(
                'label' => false,
                'required'=> false,
                'attr'  => array(
                    'placeholder' => 'instagram',
                    'class'=>'form-control',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tienda'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_tienda';
    }
}
