<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Entity\DrivingSchool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contract>
 *
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    public function findContractByClientId($clientId) {
        return $this->createQueryBuilder('i')
            ->join('i.client', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $clientId)
            ->getQuery()
            ->getResult();
    }

    public function findContractsCreatedAfterDate(\DateTimeInterface $date): array {
        return $this->createQueryBuilder('i')
            ->andWhere('i.validityDate >= :validityDate')
            ->setParameter('validityDate', $date)
            ->getQuery()
            ->getResult();
    }

    public function findTotalPriceOfContractsCreatedAfterDate(\DateTimeInterface $date): float {
        $result = $this->createQueryBuilder('i')
            ->select('SUM(i.price) as total_price')
            ->andWhere('i.validityDate >= :validityDate')
            ->setParameter('validityDate', $date)
            ->getQuery()
            ->getSingleScalarResult();

        return $result !== null ? (float) $result : 0.0;
    }

    public function getTotalPriceOfAllContracts(): float {
        $result = $this->createQueryBuilder('i')
            ->select('SUM(i.price) as total_price')
            ->getQuery()
            ->getSingleScalarResult();

        return $result !== null ? (float) $result : 0.0;
    }

    public function findByDrivingSchool($drivingSchool): array {
        return $this->createQueryBuilder('i')
            ->andWhere('i.drivingSchool = :drivingSchool')
            ->setParameter('drivingSchool', $drivingSchool)
            ->getQuery()
            ->getResult();
    }
}
