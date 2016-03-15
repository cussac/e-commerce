<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Producto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Producto
{
    /**
     * @ORM\ManyToOne(targetEntity="Tienda", inversedBy ="productos")
     * @ORM\JoinColumn(name="tienda_id", referencedColumnName="id")
     */
    private $tienda;

    public function __construct()
    {
        $this->setFecha(new\DateTime(date('y-n-d H:i:s')));
    }

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
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotBlank(message="El campo nombre no puede quedarse vacío")
     * @Assert\Length(
     *      max = 60,
     *      maxMessage = "El nombre sólo puede tener {{ limit }} letras")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     * @Assert\NotBlank(message="El campo descripcion no puede quedarse vacío")
     * @Assert\Length(
     *      max = 250,
     *      maxMessage = "La descripcion sólo puede tener {{ limit }} letras")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal")
     * @Assert\NotBlank(message="El campo precio no puede quedarse vacío")
     */
    private $precio;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     * @Assert\NotBlank(message="El campo cantidad no puede quedarse vacío")
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="peso", type="decimal")
     * @Assert\NotBlank(message="El campo peso no puede quedarse vacío")
     */
    private $peso;

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

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="string", length=55)
     *
     */
    private $categoria;
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Producto
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

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Producto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return Producto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Producto
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set peso
     *
     * @param string $peso
     * @return Producto
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return string 
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Tienda
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
     * Set tienda
     *
     * @param \AppBundle\Entity\Tienda $tienda
     * @return Producto
     */
    public function setTienda(\AppBundle\Entity\Tienda $tienda = null)
    {
        $this->tienda = $tienda;

        return $this;
    }

    /**
     * Get tienda
     *
     * @return \AppBundle\Entity\Tienda 
     */
    public function getTienda()
    {
        return $this->tienda;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     * @return Producto
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
