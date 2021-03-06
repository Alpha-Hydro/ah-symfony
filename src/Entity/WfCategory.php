<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WfCategoryRepository")
 */
class WfCategory extends BaseEntity
{
    use PageContentTrait;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WfCategory", mappedBy="parent")
     */
    private $children;

    /**
     * @var WfCategory
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\WfCategory", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WfProduct", mappedBy="category")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WfCategoryProperties", mappedBy="category")
     */
    private $properties;


    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->properties = new ArrayCollection();
    }

    /**
     * @return Collection|WfCategory[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(WfCategory $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(WfCategory $child): self
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
     * @return WfCategory|null
     */
    public function getParent(): ?WfCategory
    {
        return $this->parent;
    }

    /**
     * @param WfCategory $parent
     * @return WfCategory
     */
    public function setParent(WfCategory $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Collection|WfProduct[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(WfProduct $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(WfProduct $product): self
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

    /**
     * @return Collection|WfCategoryProperties[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(WfCategoryProperties $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setCategory($this);
        }

        return $this;
    }

    public function removeProperty(WfCategoryProperties $property): self
    {
        if ($this->properties->contains($property)) {
            $this->properties->removeElement($property);
            // set the owning side to null (unless already changed)
            if ($property->getCategory() === $this) {
                $property->setCategory(null);
            }
        }

        return $this;
    }
}
