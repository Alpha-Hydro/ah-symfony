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

interface ModuleSiteService
{
    /**
     * @param string $path
     * @return ModuleSite
     */
    public function getPageByPath(string $path):ModuleSite;
}