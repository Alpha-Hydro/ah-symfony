<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;


use App\Repository\ManufactureCategoriesRepository;

class ManufactureServiceImpl implements ManufactureService
{

    /**
     * @var ManufactureCategoriesRepository
     */
    private $repository;

    /**
     * ManufactureServiceImpl constructor.
     * @param ManufactureCategoriesRepository $repository
     */
    public function __construct(ManufactureCategoriesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function findByRootCategories(): array
    {
        return $this->repository->findByRootCategories();
    }
}