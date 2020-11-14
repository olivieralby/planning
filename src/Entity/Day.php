<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DayRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DayRepository::class)
 */
class Day
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
    private $start;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     * 
     */
    private $end;

    /**
     * @ORM\ManyToMany(targetEntity=Activite::class, mappedBy="days",cascade={"persist"})
     * @Groups("user:read")
     */
    private $activites;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="days")
     */
    private $users;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function setStart(string $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?string
    {
        return $this->end;
    }

    public function setEnd(string $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return Collection|Activite[]
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->addDay($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            $activite->removeDay($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
