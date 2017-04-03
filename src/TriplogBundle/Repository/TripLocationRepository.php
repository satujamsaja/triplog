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
    public function findAllOrderByDate()
    {
        return $this->createQueryBuilder('tripLocation')
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

    /**
     * @return TripLocation[]
     */
    public function findSomePublicOrderByDate()
    {
        return $this->createQueryBuilder('tripLocation')
            ->andWhere('tripLocation.isPublic = :isPublic')
            ->setParameter('isPublic',true)
            ->addOrderBy('tripLocation.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->execute();
    }
}