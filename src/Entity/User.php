<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"user:read"}},
 * denormalizationContext={"groups"={"user:read"}},
 * collectionOperations={
 * "post"={
 *      "controller"=App\Controller\PassController::class
 * },
 * "get"
 * },
    * itemOperations={
    * "put"={
     *   "controller"=App\Controller\PassController::class
    *},
    *   "get"
    * }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     * 
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     * 
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     * 
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     * 
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=Day::class, mappedBy="users",cascade={"persist"})
     * @Groups("user:read")
     */
    private $days;

    public function __construct()
    {
        $this->days = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername()
    {
        return $this->firstname;
    }

    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    /**
     * @return Collection|Day[]
     */
    public function getDays(): Collection
    {
        return $this->days;
    }

    public function addDay(Day $day): self
    {
        if (!$this->days->contains($day)) {
            $this->days[] = $day;
            $day->addUser($this);
        }

        return $this;
    }

    public function removeDay(Day $day): self
    {
        if ($this->days->removeElement($day)) {
            $day->removeUser($this);
        }

        return $this;
    }
}
