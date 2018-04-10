<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModificationRepository")
 * @ORM\Table(name="subproducts")
 */
class Modification extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sku;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Products", inversedBy="modifications")
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModificationParamsValues", mappedBy="modification", fetch="EAGER")
     */
    private $paramValues;

    public function __construct()
    {
        $this->paramValues = new ArrayCollection();
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection|ModificationParamsValues[]
     */
    public function getParamValues(): Collection
    {
        return $this->paramValues;
    }

    public function addParamValue(ModificationParamsValues $paramValue): self
    {
        if (!$this->paramValues->contains($paramValue)) {
            $this->paramValues[] = $paramValue;
            $paramValue->setModification($this);
        }

        return $this;
    }

    public function removeParamValue(ModificationParamsValues $paramValue): self
    {
        if ($this->paramValues->contains($paramValue)) {
            $this->paramValues->removeElement($paramValue);
            // set the owning side to null (unless already changed)
            if ($paramValue->getModification() === $this) {
                $paramValue->setModification(null);
            }
        }

        return $this;
    }
}
