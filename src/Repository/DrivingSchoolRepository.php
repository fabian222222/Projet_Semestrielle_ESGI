<?php

namespace App\Repository;

use App\Entity\DrivingSchool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DrivingSchool>
 *
 * @method DrivingSchool|null find($id, $lockMode = null, $lockVersion = null)
 * @method DrivingSchool|null findOneBy(array $criteria, array $orderBy = null)
 * @method DrivingSchool[]    findAll()
 * @method DrivingSchool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrivingSchoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DrivingSchool::class);
    }

    /**
     * @param $user
     * @return DrivingSchool[] Retourne la liste des auto écoles
     * dans lesquel l'utilisateur donné en paramètre est présent
     */
    public function findByUser($user): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere(':user MEMBER OF d.users')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return DrivingSchool[] Returns an array of DrivingSchool objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DrivingSchool
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
