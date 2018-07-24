<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryImagesRepository")
 */
class CategoryImages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uploadPath;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Categories", mappedBy="oldImages", cascade={"persist", "remove"})
     */
    private $categories;

    public function getId()
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUploadPath(): ?string
    {
        return $this->uploadPath;
    }

    public function setUploadPath(string $uploadPath): self
    {
        $this->uploadPath = $uploadPath;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        // set (or unset) the owning side of the relation if necessary
        $newOldImages = $categories === null ? null : $this;
        if ($newOldImages !== $categories->getOldImages()) {
            $categories->setOldImages($newOldImages);
        }

        return $this;
    }
}
