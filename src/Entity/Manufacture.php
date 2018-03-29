<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManufactureRepository")
 */
class Manufacture extends BaseEntity
{
    use PageContentTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ManufactureCategories", inversedBy="products")
     */
    private $category;

    public function getCategory(): ?ManufactureCategories
    {
        return $this->category;
    }

    public function setCategory(?ManufactureCategories $category): self
    {
        $this->category = $category;

        return $this;
    }

}
