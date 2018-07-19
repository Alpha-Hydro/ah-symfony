<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;


use App\Entity\Products;
use App\Repository\ProductsRepository;

class ProductServiceImpl implements ProductService
{
    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    /**
     * ProductServiceImpl constructor.
     * @param $productsRepository
     */
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
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