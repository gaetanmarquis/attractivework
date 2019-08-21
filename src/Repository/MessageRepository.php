<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // ATTENTION A VERIFIER
    /**
     * @param string $candidat
     *
     * @return array
     */
<<<<<<< HEAD
    /*public function findLike($candidat)
=======
    /*
    public function findLike($candidat)
>>>>>>> message
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.candidat LIKE :candidat')
            ->setParameter( 'candidat', "%$candidat%")
            ->orderBy('a.candidat')
            ->setMaxResults(5)
            ->getQuery()
            ->execute()
            ;
    }
    */

    // ATTENTION A VERIFIER
    /**
     * @param string $recruteur
     *
     * @return array
     */
<<<<<<< HEAD
    /*public function findLike($recruteur)
=======
    /*
    public function findLike($recruteur)
>>>>>>> message
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.recruteur LIKE :recruteur')
            ->setParameter( 'recruteur', "%$recruteur%")
            ->orderBy('a.recruteur')
            ->setMaxResults(5)
            ->getQuery()
            ->execute()
            ;
    }
    */
}
