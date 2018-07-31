<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Service;


use App\Entity\Media;
use App\Entity\MediaCategories;
use App\Repository\MediaCategoriesRepository;
use App\Repository\MediaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

class MediaServiceImpl implements MediaService
{
    /**
     * @var MediaRepository
     */
    private $mediaRepository;

    /**
     * @var MediaCategoriesRepository
     */
    private $mediaCategoriesRepository;

    /**
     * MediaServiceImpl constructor.
     * @param MediaCategoriesRepository $mediaCategoriesRepository
     * @param MediaRepository $mediaRepository
     */
    public function __construct(
        MediaCategoriesRepository $mediaCategoriesRepository,
        MediaRepository $mediaRepository
    )
    {
        $this->mediaRepository = $mediaRepository;
        $this->mediaCategoriesRepository = $mediaCategoriesRepository;
    }

    public function findByRootCategories(): array
    {
        return $this->mediaCategoriesRepository->findByRootCategories();
    }

    /**
     * @param MediaCategories $categories
     * @return Media[]
     */
    public function findByPosts(MediaCategories $categories): array
    {
        return $this->mediaRepository->findByCategory($categories);
    }

    /**
     * @param MediaCategories $categories
     * @return Collection
     */
    public function findByPostsCriteria(MediaCategories $categories): Collection
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("active", "1"))
            ->andWhere(Criteria::expr()->eq('deleted', "0"))
            ->orderBy(['update_date' => 'DESC'])
        ;

        return $categories->getPosts()->matching($criteria);
    }
}