<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media extends BaseEntity
{
    use PageContentTrait;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $path;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $sContent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MediaCategories", inversedBy="posts", fetch="EAGER")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     */
    private $author;


    public function getSContent(): ?string
    {
        return $this->sContent;
    }

    public function setSContent(?string $sContent): self
    {
        $this->sContent = $sContent;

        return $this;
    }

    public function getCategory(): ?MediaCategories
    {
        return $this->category;
    }

    public function setCategory(?MediaCategories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
