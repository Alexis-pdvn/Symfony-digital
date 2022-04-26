<?php

namespace App\Entity;

use App\Repository\ProductVariantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductVariantRepository::class)
 */
class ProductVariant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $size;

    /**
     * @ORM\OneToMany(targetEntity=ProductVariantProduct::class, mappedBy="productVariant")
     */
    private $VariantPrice;

    public function __construct()
    {
        $this->VariantPrice = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->size;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return Collection|ProductVariantProduct[]
     */
    public function getVariantPrice(): Collection
    {
        return $this->VariantPrice;
    }

    public function addVariantPrice(ProductVariantProduct $variantPrice): self
    {
        if (!$this->VariantPrice->contains($variantPrice)) {
            $this->VariantPrice[] = $variantPrice;
            $variantPrice->setProductVariant($this);
        }

        return $this;
    }

    public function removeVariantPrice(ProductVariantProduct $variantPrice): self
    {
        if ($this->VariantPrice->removeElement($variantPrice)) {
            // set the owning side to null (unless already changed)
            if ($variantPrice->getProductVariant() === $this) {
                $variantPrice->setProductVariant(null);
            }
        }

        return $this;
    }
}
