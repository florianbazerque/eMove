<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeUser", inversedBy="users", cascade={"persist"})
     */
    private $typeUser;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;
    /**
     * @var string $email
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fidelityPoint;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $spendPoint;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telNum;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $licenceNum;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="user")
     */
    private $locations;
    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
        $this->typeUser = (new TypeUser())->getId();
    }
    public function getId()
    {
        return $this->id;
    }
    public function getTypeUser(): ?TypeUser
    {
        return $this->typeUser;
    }
    public function setTypeUser(?TypeUser $typeUser): self
    {
        $this->typeUser = $typeUser;
        return $this;
    }
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }
    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }
    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }
    public function getFidelityPoint(): ?int
    {
        if($this->fidelityPoint == null)
            $this->fidelityPoint = 0;

        return $this->fidelityPoint;
    }
    public function setFidelityPoint(?int $fidelityPoint): self
    {
        $this->fidelityPoint = $fidelityPoint;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpendPoint()
    {
        if($this->spendPoint == null)
            $this->spendPoint = 0;

        return $this->spendPoint;
    }

    /**
     * @param mixed $spendPoint
     */
    public function setSpendPoint($spendPoint): void
    {
        $this->spendPoint = $spendPoint;
    }

    public function getTelNum(): ?int
    {
        return $this->telNum;
    }
    public function setTelNum(?int $telNum): self
    {
        $this->telNum = $telNum;
        return $this;
    }
    public function getLicenceNum(): ?string
    {
        return $this->licenceNum;
    }
    public function setLicenceNum(?string $licenceNum): self
    {
        $this->licenceNum = $licenceNum;
        return $this;
    }
    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }
    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setUser($this);
        }
        return $this;
    }
    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getUser() === $this) {
                $location->setUser(null);
            }
        }
        return $this;
    }
    public function getUtilisateur()
    {
        return $this->getId();
    }
    //Connection functions
    public function getUsername()
    {
        return $this->email;
    }
    public function getSalt()
    {
        return null;
    }
    public function getRoles()
    {
        $roleId = $this->getTypeUser()->getLabel();
        if($roleId === "Administrateur") {
            return ['ROLE_ADMIN'];
        } else {
            return ['ROLE_USER'];
        }
    }
    /* public function getRoles()
     {
         return $this->roles;
     }*/
    public function eraseCredentials()
    {
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            //$this->salt,
        ]);
    }
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            //$this->salt,
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}