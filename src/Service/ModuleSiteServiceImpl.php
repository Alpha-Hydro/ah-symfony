<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;


use App\Entity\ModuleSite;
use App\Repository\ModuleSiteRepository;

class ModuleSiteServiceImpl implements ModuleSiteService
{
    /**
     * @var ModuleSiteRepository
     */
    private $repository;

    /**
     * ModuleSiteServiceImpl constructor.
     * @param ModuleSiteRepository $repository
     */
    public function __construct(ModuleSiteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $path
     * @return ModuleSite
     */
    public function getPageByPath(string $path): ModuleSite
    {
        return $this->repository->findOneBy(['path' => $path]);
    }
}