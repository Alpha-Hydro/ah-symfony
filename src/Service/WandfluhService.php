<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;


use App\Entity\WfCategory;
use Doctrine\Common\Collections\Collection;

interface WandfluhService
{
    /**
     * @return WfCategory[]
     */
    public function findByRootCategories(): array;

    /**
     * @param WfCategory|null $category
     * @return WfCategory[]|null
     */
    public function getBreadcrumbs(WfCategory $category = null): ?array;

    /**
     * @param WfCategory|null $parentCategory
     * @return WfCategory[]|array|Collection
     */
    public function getSidebarListCategories(WfCategory $parentCategory = null);

    /**
     * @param WfCategory $category
     * @return WfCategory[]
     */
    public function findByChildren(WfCategory $category): array;

    /**
     * @param string $fullPath
     * @return WfCategory|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByFullPath(string $fullPath): ?WfCategory;
}