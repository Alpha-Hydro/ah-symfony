<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories extends BaseEntity
{
    use PageContentTrait;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Categories", mappedBy="parent")
     */
    private $children;

    /**
     * @var Categories
     *
     * the association is marked as EAGER or LAZY
     * See https://stackoverflow.com/questions/26891658/what-is-the-difference-between-fetch-eager-and-fetch-lazy-in-doctrine
     *
     * the association is marked as EXTRA_LAZY
     * See http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/extra-lazy-associations.html
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Products", mappedBy="category")
     */
    private $products;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    /**
     * @param bool $all
     * @return Collection|Categories[]
     */
    public function getChildren(bool $all = false): Collection
    {
        if ($all === true) return $this->children;

        $criteria = Criteria::create();
        $criteria
            ->where(Criteria::expr()->eq('active', 1))
            ->where(Criteria::expr()->eq('deleted', 0));
        $criteria->orderBy(['sorting' => Criteria::ASC]);

        return $this->children->matching($criteria);
    }

    public function addChild(Categories $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Categories $child): self
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
     * @return Categories|null
     */
    public function getParent(): ?Categories
    {
        return $this->parent;
    }

    /**
     * @param Categories $parent
     * @return Categories
     */
    public function setParent(Categories $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
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
