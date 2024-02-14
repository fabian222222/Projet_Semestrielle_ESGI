<?php

namespace App\Repository;

use App\Entity\Invoice;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invoice>
 *
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

    /**
     * @param $drivingSchoolId
     * @return Invoice[] Retourne la liste des factures de l'auto école
     * donné en paramètre
     */
    public function findByDrivingSchoolId($drivingSchoolId): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.drivingSchool = :drivingSchoolId')
            ->setParameter('drivingSchoolId', $drivingSchoolId)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByInvoiceName(string $name): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }

    public function findInvoiceByClientId($clientId) {
        return $this->createQueryBuilder('i')
            ->join('i.client', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $clientId)
            ->getQuery()
            ->getResult();
    }
}
