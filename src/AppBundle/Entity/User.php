<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="username", message="Nombre de usuario no disponible")
 * @UniqueEntity(fields="email", message="Este email ya esta registrado")
 */
class User implements UserInterface
{

    /**
     * @ORM\OneToMany(targetEntity="Tienda", mappedBy="user", orphanRemoval=true)
     */
    private $tiendas;
    public function __construct()
    {
        $this->tiendas = new ArrayCollection();
        $this->setFecha(new\DateTime(date('y-n-d H:i:s')));
        $this->setTokenRegistro($this->randomString());
        $this->setSalt($this->randomString());
        $this->setIsActive(true);
    }

    private $temp;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=64)
     *
     * @Assert\NotBlank(message="El campo NOMBRE: es obligatorio.")
     * @Assert\Length(
     *      min="3",
     *      max="64",
     *      minMessage=" : El campo NOMBRE: debe tener mínimo {{ limit }} caracteres.",
     *      maxMessage=" : El campo NOMBRE: debe tener máximo {{ limit }} caracteres."
     * )
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z\s]+$/",
     *      message="El campo NOMBRE: sólo puede contener letras")
     */
    private $nombre;
    /**
     * @var string
     *
     * @ORM\Column(name="apellido1", type="string", length=64)
     *
     * @Assert\NotBlank(message="El campo PRIMER APELLIDO: es obligatorio.")
     * @Assert\Length(
     *      min="3",
     *      max="64",
     *      minMessage=" : El campo PRIMER APELLIDO: debe tener mínimo {{ limit }} caracteres.",
     *      maxMessage=" : El campo PRIMER APELLIDO: debe tener máximo {{ limit }} caracteres."
     * )
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z\s]+$/",
     *      message="El campo PRIMER APELLIDO: sólo puede contener letras")
     */
    private $apellido1;
    /**
     * @var string
     *
     * @ORM\Column(name="apellido2", type="string", length=64, nullable=true)
     *
     * @Assert\Length(
     *      max="64",
     *      maxMessage=" : El campo SEGUNDO APELLIDO: debe tener máximo {{ limit }} caracteres."
     * )
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z\s]+$/",
     *      message="El campo SEGUNDO APELLIDO: sólo puede contener letras")
     */
    private $apellido2;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(message="El campo EMAIL: es obligatorio.")
     * @Assert\Email(message = "El email {{ value }} no es válido.")
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, unique=true)
     *
     * @Assert\NotBlank(message="El campo NOMBRE DE USUARIO: es obligatorio.")
     *
     * @Assert\Length(
     *      min="3",
     *      max="64",
     *      minMessage=" : El campo NOMBRE DE USUARIO: debe tener mínimo {{ limit }} catacteres.",
     *      maxMessage=" : El campo NOMBRE DE USUARIO: debe tener máximo {{ limit }} catacteres."
     * )
     * @Assert\Regex(
     *      pattern="/^[\w-]+$/",
     *      message="El campo NOMBRE DE USUARIO: sólo caracteres alfanuméricos y guiones")
     */
    private $username;
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     *
     * @Assert\NotBlank(
     *      message=" El campo CONTRASEÑA: es un campo obligatorio."
     * )
     *
     * @Assert\Length(
     *      min="5",
     *      max="255",
     *      minMessage=" El campo CONTRASEÑA: debe tener una longitud mínima de {{ limit }} catacteres.",
     *      maxMessage=" El campo CONTRASEÑA: como máximo puede tener {{ limit }} catacteres."
     * )
     */
    private $password;
    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=30)
     */
    private $rol;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;
    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;
    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;
    /**
     * @var string
     *
     * @ORM\Column(name="tokenRegistro", type="string", length=255)
     */
    private $tokenRegistro;
    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;
    /**
     * Get id
     *
     * @return integer
     */
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
     * @return User
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
     * Set apellido1
     *
     * @param string $apellido1
     * @return User
     */
    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
        return $this;
    }
    /**
     * Get apellido1
     *
     * @return string
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }
    /**
     * Set apellido2
     *
     * @param string $apellido2
     * @return User
     */
    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;
        return $this;
    }
    /**
     * Get apellido2
     *
     * @return string
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }
    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set rol
     *
     * @param string $rol
     * @return User
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
        return $this;
    }
    /**
     * Get rol
     *
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }
    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return User
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
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }
    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }
    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    /**
     * Set tokenRegistro
     *
     * @param string $tokenRegistro
     * @return User
     */
    public function setTokenRegistro($tokenRegistro)
    {
        $this->tokenRegistro = $tokenRegistro;
        return $this;
    }
    /**
     * Get tokenRegistro
     *
     * @return string
     */
    public function getTokenRegistro()
    {
        return $this->tokenRegistro;
    }
    function equals(UserInterface $user)
    {
        return $user->getUsername() === $this->username;
    }
    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }
    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (Boolean) $termsAccepted;
    }
    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }
    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }
    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->getIsActive();
    }
    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }
    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return array($this->getRol());
    }
    /****** CUSTOM METHOD ********/
    private function randomString($length = 20)
    {
        $length = 20;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * Set tienda
     *
     * @param \AppBundle\Entity\Tienda $tienda
     * @return User
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
     * Add tienda
     *
     * @param \AppBundle\Entity\Tienda $tienda
     * @return User
     */
    public function addTienda(\AppBundle\Entity\Tienda $tienda)
    {
        $this->tienda[] = $tienda;
        return $this;
    }
    /**
     * Remove tienda
     *
     * @param \AppBundle\Entity\Tienda $tienda
     */
    public function removeTienda(\AppBundle\Entity\Tienda $tienda)
    {
        $this->tienda->removeElement($tienda);
    }
    /**
     * Get tiendas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTiendas()
    {
        return $this->tiendas;
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
}