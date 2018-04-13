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
use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\Collection;

/**
 * Class CatalogServiceImpl
 * @package App\Service
 */
class CatalogServiceImpl implements CatalogService
{
    /**
     * @var CategoriesRepository
     */
    private $repository;

    /**
     * CatalogController constructor.
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->repository = $categoriesRepository;
    }

    /**
     * @param Categories|null $category
     * @return array|null
     */
    public function getBreadcrumbs(Categories $category = null): ?array
    {
        if ($category == null)
            return null;

        $result = [];
        do {
            $result[] = $category;
            $category = $category->getParent();
        } while ($category != null);

        if (!empty($result))
            $result = array_reverse($result);

        return $result;
    }

    /**
     * @param Categories $parentCategory
     * @return Categories[]|array|Collection
     */
    public function getSidebarListCategories(Categories $parentCategory = null)
    {
        $sidebarListCategories = $this->findByRootCategories();

        if ($parentCategory != null && $parentCategory->getId() != 0)
            $sidebarListCategories = $this->findByChildren($parentCategory);

        return $sidebarListCategories;
    }

    /**
     * @param Categories $category
     * @return Categories[]
     */
    public function findByChildren(Categories $category): array
    {
        return $this->repository->findByChildren($category);
    }

    /**
     * @param string $fullPath
     * @return Categories|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByFullPath(string $fullPath): ?Categories
    {
        return $this->repository->findByFullPath($fullPath);
    }

    public function findByRootCategories(): array
    {
        return $this->repository->findByRootCategories();
    }
}