<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;


use App\Entity\Categories;
use Doctrine\Common\Collections\Collection;

interface CatalogService
{
    /**
     * @return Categories[]
     */
    public function findByRootCategories(): array;

    /**
     * @param Categories|null $category
     * @return array|null
     */
    public function getBreadcrumbs(Categories $category = null): ?array;

    /**
     * @param Categories|null $parentCategory
     * @return Categories[]|array|Collection
     */
    public function getSidebarListCategories(Categories $parentCategory = null);

    /**
     * @param Categories $category
     * @return Categories[]
     */
    public function findByChildren(Categories $category): array;

    /**
     * @param string $fullPath
     * @return Categories|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByFullPath(string $fullPath): ?Categories;

    public function findProductBySearchQuery(string $query): array;
}