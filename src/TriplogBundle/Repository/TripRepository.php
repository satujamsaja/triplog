<?php


namespace TriplogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use TriplogBundle\Entity\Trip;


class TripRepository extends EntityRepository
{
    /**
     * @return Trip[]
     */
    public function findAllPublicOrderByDate()
    {
        return $this->createQueryBuilder('trip')
            ->andWhere('trip.isPublic = :isPublic')
            ->setParameter('isPublic',true)
            ->addOrderBy('trip.createdAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    /**
     * @return Trip[]
     */
    public function findAllOrderByDate()
    {
        return $this->createQueryBuilder('trip')
            ->addOrderBy('trip.createdAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    /**
    * @return Trip[]
    */
    public function findOnePublicById($id)
    {
        return $this->createQueryBuilder('trip')
            ->andWhere('trip.isPublic = :isPublic')
            ->andWhere('trip.id = :id')
            ->setParameters([
                'isPublic' => true,
                'id' => $id
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

}