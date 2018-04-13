<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WfProductRepository")
 */
class WfProduct extends BaseEntity
{
    /**
     * @ORM\Column(type="string", length=11)
     */
    private $dataSheetNo;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $dataSheetPdf;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WfCategory", inversedBy="products")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WfProductType", inversedBy="products", fetch="EAGER")
     */
    private $productType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WfProductSize", inversedBy="products", fetch="EAGER")
     */
    private $productSize;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WfProductControl", inversedBy="products", fetch="EAGER")
     */
    private $productControl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WfProductConstruction", inversedBy="products", fetch="EAGER")
     */
    private $productConstruction;

    public function getDataSheetNo(): ?string
    {
        return $this->dataSheetNo;
    }

    public function setDataSheetNo(string $dataSheetNo): self
    {
        $this->dataSheetNo = $dataSheetNo;

        return $this;
    }

    public function getDataSheetPdf(): ?string
    {
        return $this->dataSheetPdf;
    }

    public function setDataSheetPdf(string $dataSheetPdf): self
    {
        $this->dataSheetPdf = $dataSheetPdf;

        return $this;
    }

    public function getCategory(): ?WfCategory
    {
        return $this->category;
    }

    public function setCategory(?WfCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getProductType(): ?WfProductType
    {
        return $this->productType;
    }

    public function setProductType(?WfProductType $productType): self
    {
        $this->productType = $productType;

        return $this;
    }

    public function getProductSize(): ?WfProductSize
    {
        return $this->productSize;
    }

    public function setProductSize(?WfProductSize $productSize): self
    {
        $this->productSize = $productSize;

        return $this;
    }

    public function getProductControl(): ?WfProductControl
    {
        return $this->productControl;
    }

    public function setProductControl(?WfProductControl $productControl): self
    {
        $this->productControl = $productControl;

        return $this;
    }

    public function getProductConstruction(): ?WfProductConstruction
    {
        return $this->productConstruction;
    }

    public function setProductConstruction(?WfProductConstruction $productConstruction): self
    {
        $this->productConstruction = $productConstruction;

        return $this;
    }


}
