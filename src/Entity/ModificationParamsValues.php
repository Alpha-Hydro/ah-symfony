<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModificationParamsValueRepository")
 * @ORM\Table(name="subproduct_params_values")
 */
class ModificationParamsValues
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modification", inversedBy="paramValues")
     * @ORM\JoinColumn(name="subproduct_id", referencedColumnName="id")
     *
     * @ORM\JoinTable(name="subproducts_params",
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="param_id", referencedColumnName="id")
     *     }
     * )
     *
     */
    private $modification;

    /**
     * @ORM\Column(type="integer")
     */
    private $paramId;

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

    public function getModification(): ?Modification
    {
        return $this->modification;
    }

    public function setModification(?Modification $modification): self
    {
        $this->modification = $modification;

        return $this;
    }

    public function getParamId(): ?int
    {
        return $this->paramId;
    }

    public function setParamId(int $paramId): self
    {
        $this->paramId = $paramId;

        return $this;
    }
}
