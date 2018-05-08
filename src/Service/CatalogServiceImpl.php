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
    private $categoriesRepository;

    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    /**
     * CatalogController constructor.
     * @param CategoriesRepository $categoriesRepository
     * @param ProductsRepository $productsRepository
     */
    public function __construct(CategoriesRepository $categoriesRepository, ProductsRepository $productsRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
        $this->productsRepository = $productsRepository;
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

    /**
     * @param string $query
     * @return Products[]
     */
    public function findProductBySearchQuery(string $query): array
    {
        $query = str_replace(array('.',',',' ','-','_','/','\\','*','+','&','^','%','#','@','!','(',')','~','<','>',':',';','"',"'","|"), '', $query);

        return $this->productsRepository->searchSqlQuery($query);

    }
}