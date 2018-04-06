<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 * @ORM\Table(
 *     indexes={
 *          @ORM\Index(
 *              columns={"name", "s_name", "sku", "meta_keywords"},
 *              flags={"fulltext"}
 *          )
 *     }
 * )
 */
class Products extends BaseEntity
{
    use PageContentTrait;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sku;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $sName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $draft;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uploadPathDraft;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="products")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductParams", mappedBy="product")
     */
    private $params;

    public function __construct()
    {
        $this->params = new ArrayCollection();
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

    public function getSName(): ?string
    {
        return $this->sName;
    }

    public function setSName(?string $sName): self
    {
        $this->sName = $sName;

        return $this;
    }

    public function getDraft(): ?string
    {
        return $this->draft;
    }

    public function setDraft(?string $draft): self
    {
        $this->draft = $draft;

        return $this;
    }

    public function getUploadPathDraft(): ?string
    {
        return $this->uploadPathDraft;
    }

    public function setUploadPathDraft(?string $uploadPathDraft): self
    {
        $this->uploadPathDraft = $uploadPathDraft;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|ProductParams[]
     */
    public function getParams(): Collection
    {
        return $this->params;
    }

    public function addParam(ProductParams $param): self
    {
        if (!$this->params->contains($param)) {
            $this->params[] = $param;
            $param->setProduct($this);
        }

        return $this;
    }

    public function removeParam(ProductParams $param): self
    {
        if ($this->params->contains($param)) {
            $this->params->removeElement($param);
            // set the owning side to null (unless already changed)
            if ($param->getProduct() === $this) {
                $param->setProduct(null);
            }
        }

        return $this;
    }
}
