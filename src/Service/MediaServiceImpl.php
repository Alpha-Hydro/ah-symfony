<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;


use App\Repository\MediaCategoriesRepository;
use App\Repository\MediaRepository;

class MediaServiceImpl implements MediaService
{
    /**
     * @var MediaRepository
     */
    private $repository;

    /**
     * MediaServiceImpl constructor.
     * @param MediaCategoriesRepository $repository
     */
    public function __construct(MediaCategoriesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findByRootCategories(): array
    {
        return $this->repository->findByRootCategories();
    }

}