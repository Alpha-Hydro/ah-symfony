<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Form;


use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class CategoriesToNumberTransformer
 * @package App\Form
 */
class CategoriesToNumberTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CategoriesToNumberTransformer constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Categories|null $category
     * @return string
     */
    public function transform($category = null): string
    {
        if (null === $category) {
            return '';
        }

        return $category->getId();
    }

    /**
     * @param $category_id
     * @return Categories|null
     */
    public function reverseTransform($category_id)
    {
        if (!$category_id) {
            return null;
        }

        $category = $this->entityManager
            ->getRepository(Categories::class)
            ->find($category_id);

        if (null === $category) {
            throw new TransformationFailedException(
                sprintf('An category with id "%s" does not exist!', $category_id)
            );
        }

        return $category;
    }
}