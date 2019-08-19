<?php

namespace App\Repository;

use App\Entity\Personnalite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Personnalite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personnalite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personnalite[]    findAll()
 * @method Personnalite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnaliteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Personnalite::class);
    }

    // /**
    //  * @return Personnalite[] Returns an array of Personnalite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Personnalite
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
