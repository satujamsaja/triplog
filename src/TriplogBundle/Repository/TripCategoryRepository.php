<?php


namespace TriplogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use TriplogBundle\Entity\TripCategory;

class TripCategoryRepository extends EntityRepository
{
    /**
     * @return TripCategory[]
     */
    public function findAllOrderByName()
    {
        return $this->createQueryBuilder('tripCategory')
            ->addOrderBy('tripCategory.tripCatName', 'ASC')
            ->getQuery()
            ->execute();
    }
}