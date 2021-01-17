<?php

namespace App\Entity;

use App\Repository\CommodityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Exception;

/**
 * @ORM\Entity(repositoryClass=CommodityRepository::class)
 * @Vich\Uploadable()
 */
class Commodity implements \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Image(mimeTypes={"image/png", "image/jpeg"})
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="commodity_image", fileNameProperty="image")
     * @Assert\Image(mimeTypes={"image/png", "image/jpeg"}, maxSize="2M")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $remaining;

    /**
     * @ORM\ManyToMany(targetEntity=Business::class, inversedBy="commodities")
     */
    private $business;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Cart::class, mappedBy="commodity")
     */
    private $carts;

    /**
     * @ORM\ManyToMany(targetEntity=Command::class, mappedBy="commodity")
     */
    private $commands;

    public function __construct()
    {
        $this->business = new ArrayCollection();
        $this->carts = new ArrayCollection();
        $this->commands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     * @return Commodity
     */
    public function setImageFile($imageFile) {
        $this->imageFile = $imageFile;

        if($imageFile != null) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRemaining(): ?int
    {
        return $this->remaining;
    }

    public function setRemaining(int $remaining): self
    {
        $this->remaining = $remaining;

        return $this;
    }

    /**
     * @return Collection|Business[]
     */
    public function getBusiness(): Collection
    {
        return $this->business;
    }

    public function addBusiness(Business $business): self
    {
        if (!$this->business->contains($business)) {
            $this->business[] = $business;
        }

        return $this;
    }

    public function removeBusiness(Business $business): self
    {
        $this->business->removeElement($business);

        return $this;
    }

    public function serialize()
    {
        return serialize([
            'id' => $this->id,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            ) = array_values(unserialize($serialized));
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Cart[]
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts[] = $cart;
            $cart->addCommodity($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->removeElement($cart)) {
            $cart->removeCommodity($this);
        }

        return $this;
    }

    /**
     * @return Collection|Command[]
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->addCommodity($this);
        }

        return $this;
    }

    public function removeCommand(Command $command): self
    {
        if ($this->commands->removeElement($command)) {
            $command->removeCommodity($this);
        }

        return $this;
    }
}
