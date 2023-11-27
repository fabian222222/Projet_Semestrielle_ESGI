<?php

namespace App\Repository;

use App\Entity\ContractDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContractDetail>
 *
 * @method ContractDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractDetail[]    findAll()
 * @method ContractDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractDetail::class);
    }

//    /**
//     * @return ContractDetail[] Returns an array of ContractDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ContractDetail
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
