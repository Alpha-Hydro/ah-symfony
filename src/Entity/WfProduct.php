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


}
