<?php

namespace App\Repository;

use App\Entity\NumberStore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NumberStore|null find($id, $lockMode = null, $lockVersion = null)
 * @method NumberStore|null findOneBy(array $criteria, array $orderBy = null)
 * @method NumberStore[]    findAll()
 * @method NumberStore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumberStoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NumberStore::class);
    }

    public function findLatest(int $limit): array
    {
        return $this->findBy([], ['updatedAt' => 'DESC'], $limit);
    }

    // /**
    //  * @return NumberStore[] Returns an array of NumberStore objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NumberStore
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save(int $number): void
    {
        $newNumberStore = new NumberStore($number);

        $this->_em->persist($newNumberStore);
        $this->_em->flush();
    }
}
