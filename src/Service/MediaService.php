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

interface MediaService
{
    /**
     * @return MediaCategories[]
     */
    public function findByRootCategories(): array;
}