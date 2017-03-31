<?php


namespace TriplogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use TriplogBundle\Entity\TripLocation;

class TripLocationRepository extends EntityRepository
{

    /**
     * @return TripLocation[]
     */
    public function findAllPublicOrderByDate()
    {
        return $this->createQueryBuilder('tripLocation')
            ->andWhere('tripLocation.isPublic = :isPublic')
            ->setParameter('isPublic',true)
            ->addOrderBy('tripLocation.createdAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    /**
     * @return TripLocation[]
     */
    public function findOnePublicById($id)
    {
        return $this->createQueryBuilder('tripLocation')
            ->andWhere('tripLocation.isPublic = :isPublic')
            ->andWhere('tripLocation.id = :id')
            ->setParameters([
                'isPublic' => true,
                'id' => $id
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

}