<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }


    public function findPublier()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.publier = :val')
            ->setParameter('val', 1)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAll()
    {
        return $this->findBy(array(), array('dateCreation' => 'DESC'));
    }

}
