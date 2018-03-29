<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManufactureCategoriesRepository")
 */
class ManufactureCategories extends BaseEntity
{
    use PageContentTrait;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ManufactureCategories", mappedBy="parent")
     */
    private $children;

    /**
     * @var ManufactureCategories
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ManufactureCategories", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manufacture", mappedBy="category")
     */
    private $products;


    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    /**
     * @return Collection|ManufactureCategories[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(ManufactureCategories $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(ManufactureCategories $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return ManufactureCategories
     */
    public function getParent(): ManufactureCategories
    {
        return $this->parent;
    }

    /**
     * @param ManufactureCategories $parent
     * @return ManufactureCategories
     */
    public function setParent(ManufactureCategories $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Collection|Manufacture[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Manufacture $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Manufacture $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }
}
