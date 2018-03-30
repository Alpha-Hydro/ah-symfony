<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleSiteRepository")
 * @ORM\Table(name="pages")
 */
class ModuleSite extends BaseEntity
{
    use PageContentTrait;
}
