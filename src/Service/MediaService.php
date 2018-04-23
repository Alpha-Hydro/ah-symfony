<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;


use App\Entity\MediaCategories;
use Doctrine\Common\Collections\Collection;

interface MediaService
{
    /**
     * @return MediaCategories[]
     */
    public function findByRootCategories(): array;


    /**
     * @param MediaCategories $categories
     * @return array
     */
    public function findByPosts(MediaCategories $categories): array;

    /**
     * @param MediaCategories $categories
     * @return Collection
     */
    public function findByPostsCriteria(MediaCategories $categories): Collection;
}