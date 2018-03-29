<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
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
}
