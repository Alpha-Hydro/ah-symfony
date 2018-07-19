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
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Common\Collections\Collection;

/**
 * Class CategoriesServiceImpl
 * @package App\Service
 */
class CategoriesServiceImpl implements CategoriesService
{
    /**
     * @var CategoriesRepository
     */
    private $categoriesRepository;

    /**
     * CatalogController constructor.
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
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
     * @param Categories|null $category
     * @return string|null
     */
    public function createFullPath(Categories $category = null): ?string
    {
        if ($category == null)
            return null;

        $result = [];
        $array = $this->getBreadcrumbs($category);
        foreach ($array as $item){
            $result[] = $item->getPath();
        }

        return trim(implode('/',$result));
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
        return $this->categoriesRepository->findByChildren($category);
    }

    /**
     * @param string $fullPath
     * @return Categories|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByFullPath(string $fullPath): ?Categories
    {
        return $this->categoriesRepository->findByFullPath($fullPath);
    }

    /**
     * @return Categories[]
     */
    public function findByRootCategories(): array
    {
        return $this->categoriesRepository->findByRootCategories();
    }
}