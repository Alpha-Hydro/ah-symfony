<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WfCategoryPropertiesRepository")
 */
class WfCategoryProperties
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WfCategory", inversedBy="properties")
     */
    private $category;

    public function getId()
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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
