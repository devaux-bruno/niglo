<?php

namespace App\Repository;

use App\Entity\Partenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Partenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partenaire::class);
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
        return $this->findBy(array(), array('dateAjout' => 'DESC'));
    }

}