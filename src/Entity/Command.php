<?php

namespace App\Entity;

use App\Repository\CommandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandRepository::class)
 */
class Command
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_command;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commands")
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Commodity::class, inversedBy="commands")
     */
    private $commodity;

    public function __construct()
    {
        $this->commodity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbCommand(): ?int
    {
        return $this->nb_command;
    }

    public function setNbCommand(int $nb_command): self
    {
        $this->nb_command = $nb_command;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Commodity[]
     */
    public function getCommodity(): Collection
    {
        return $this->commodity;
    }

    public function addCommodity(Commodity $commodity): self
    {
        if (!$this->commodity->contains($commodity)) {
            $this->commodity[] = $commodity;
        }

        return $this;
    }

    public function removeCommodity(Commodity $commodity): self
    {
        $this->commodity->removeElement($commodity);

        return $this;
    }
}
