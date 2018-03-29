<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait CategoriesIdxTrait
{
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $categoryIdx;

    public function getCategoryIdx(): ?int
    {
        return $this->categoryIdx;
    }

    public function setCategoryIdx(?int $categoryIdx): self
    {
        $this->categoryIdx = $categoryIdx;

        return $this;
    }
}
