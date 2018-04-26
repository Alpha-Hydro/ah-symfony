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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $path;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="products", fetch="EAGER")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductParams", mappedBy="product")
     * @ORM\OrderBy({"sorting" = "ASC"})
     */
    private $params;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modification", mappedBy="product")
     * @ORM\OrderBy({"sorting" = "ASC"})
     */
    private $modifications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModificationParams", mappedBy="product")
     * @ORM\OrderBy({"sorting" = "ASC"})
     */
    private $modificationParams;

    public function __construct()
    {
        $this->params = new ArrayCollection();
        $this->modifications = new ArrayCollection();
        $this->modificationParams = new ArrayCollection();
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

    /**
     * @return Collection|Modification[]
     */
    public function getModifications(): Collection
    {
        return $this->modifications;
    }

    public function addModification(Modification $modification): self
    {
        if (!$this->modifications->contains($modification)) {
            $this->modifications[] = $modification;
            $modification->setProduct($this);
        }

        return $this;
    }

    public function removeModification(Modification $modification): self
    {
        if ($this->modifications->contains($modification)) {
            $this->modifications->removeElement($modification);
            // set the owning side to null (unless already changed)
            if ($modification->getProduct() === $this) {
                $modification->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ModificationParams[]
     */
    public function getModificationParams(): Collection
    {
        return $this->modificationParams;
    }

    public function addModificationParam(ModificationParams $modificationParam): self
    {
        if (!$this->modificationParams->contains($modificationParam)) {
            $this->modificationParams[] = $modificationParam;
            $modificationParam->setProduct($this);
        }

        return $this;
    }

    public function removeModificationParam(ModificationParams $modificationParam): self
    {
        if ($this->modificationParams->contains($modificationParam)) {
            $this->modificationParams->removeElement($modificationParam);
            // set the owning side to null (unless already changed)
            if ($modificationParam->getProduct() === $this) {
                $modificationParam->setProduct(null);
            }
        }

        return $this;
    }
}
