<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Commodity::class, inversedBy="carts")
     */
    private $commodity;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="cart", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->commodity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setCart(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getCart() !== $this) {
            $user->setCart($this);
        }

        $this->user = $user;

        return $this;
    }
}
