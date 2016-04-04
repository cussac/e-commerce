<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Producto
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Producto
{
    /**
     * @ORM\ManyToOne(targetEntity="Tienda", inversedBy ="productos")
     * @ORM\JoinColumn(name="tienda_id", referencedColumnName="id")
     */
    private $tienda;

    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="producto")
     *
     */
    private $comentarios;

    public function __construct()
    {
        $this->comentarios = new ArrayCollection();

        $this->setFecha(new\DateTime(date('y-n-d H:i:s')));
    }
    private $temp;
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
     * @ORM\Column(name="peso", type="decimal", nullable=true)
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
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

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
    /****IMAGENES****/
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
    }
    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }
    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'uploads/documents';
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // haz lo que quieras para generar un nombre único
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }
    }
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        // si hay un error al mover el archivo, move() automáticamente
        // envía una excepción. This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);
        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }
    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
    /**
     * Set path
     *
     * @param string $path
     * @return User
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Add comentarios
     *
     * @param \AppBundle\Entity\Comentario $comentarios
     * @return Producto
     */
    public function addComentario(\AppBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios[] = $comentarios;

        return $this;
    }

    /**
     * Remove comentarios
     *
     * @param \AppBundle\Entity\Comentario $comentarios
     */
    public function removeComentario(\AppBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios->removeElement($comentarios);
    }

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }
}
