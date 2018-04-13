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
use App\Entity\WfProduct;
use App\Repository\WfCategoryRepository;
use Doctrine\Common\Collections\Collection;

class WfCategoryService implements WandfluhService
{
    /**
     * @var WfCategoryRepository
     */
    private $repository;

    /**
     * CatalogController constructor.
     * @param WfCategoryRepository $categoriesRepository
     */
    public function __construct(WfCategoryRepository $categoriesRepository)
    {
        $this->repository = $categoriesRepository;
    }

    /**
     * @return WfCategory[]
     */
    public function findByRootCategories(): array
    {
        return $this->repository->findByRootCategories();
    }

    /**
     * @param WfCategory|null $category
     * @return WfCategory[]|null
     */
    public function getBreadcrumbs(WfCategory $category = null): ?array
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
     * @param WfCategory|null $parentCategory
     * @return WfCategory[]|array|Collection
     */
    public function getSidebarListCategories(WfCategory $parentCategory = null)
    {
        $sidebarListCategories = $this->findByRootCategories();

        if ($parentCategory != null && $parentCategory->getId() != 0)
            $sidebarListCategories = $this->findByChildren($parentCategory);

        return $sidebarListCategories;
    }

    /**
     * @param WfCategory $category
     * @return WfCategory[]|array
     */
    public function findByChildren(WfCategory $category): array
    {
        return $this->repository->findByChildren($category);
    }

    public function findByFullPath(string $fullPath): ?WfCategory
    {
        return $this->repository->findByFullPath($fullPath);
    }

    /**
     * @param WfCategory $category
     * @return WfProduct[]|array
     */
    public function groupProductsByControl(WfCategory $category): array
    {
        $result = [];
        if (!empty($productList = $category->getProducts())){
            foreach ($productList as $product) {
                $productControl = ($product->getProductControl() != null) ? $product->getProductControl()->getName() : $product->getCategory()->getName();
                $result[$productControl][] = $product;
            }
        }
        return $result;
    }
}