<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comentario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ComentarioRepository")
 */
class Comentario
{
    public function __construct()
    {
        $this->setFecha(new\DateTime(date('y-n-d H:i:s')));
    }

    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy = "producto")
     *
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy = "user")
     *
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=50)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="string", length=140)
     */
    private $contenido;
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=64, nullable=true)
     *
     * @Assert\Length(
     *      max="64",
     *      maxMessage=" : El campo NOMBRE: debe tener máximo {{ limit }} caracteres."
     * )
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z\s]+$/",
     *      message="El campo NOMBRE: sólo puede contener letras")
     */
    private $nombre;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Comentario
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     * @return Comentario
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Comentario
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set producto
     *
     * @param \AppBundle\Entity\Producto $producto
     * @return Comentario
     */
    public function setProducto(\AppBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \AppBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Comentario
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Comentario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
