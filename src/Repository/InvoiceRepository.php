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

    public function findByInvoiceNameAndDescription(string $search): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.name LIKE :name')
            ->orWhere('q.description LIKE :description')
            ->setParameter('name', '%' . $search . '%')
            ->setParameter('description', '%' . $search . '%')
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

    public function findInvoicesCreatedAfterDate(\DateTimeInterface $date): array   {
        return $this->createQueryBuilder('i')
            ->andWhere('i.date >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    public function findTotalPriceOfInvoicesCreatedAfterDate(\DateTimeInterface $date): float {
        $result = $this->createQueryBuilder('i')
            ->select('SUM(i.price) as total_price')
            ->andWhere('i.date >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();

        return $result !== null ? (float) $result : 0.0;
    }

    public function getTotalPriceOfAllInvoices(): float {
        $result = $this->createQueryBuilder('i')
            ->select('SUM(i.price) as total_price')
            ->getQuery()
            ->getSingleScalarResult();

        return $result !== null ? (float) $result : 0.0;
    }

    public function findByTypePayment(string $typePayment): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.typePayment = :typePayment')
            ->setParameter('typePayment', $typePayment)
            ->getQuery()
            ->getResult();
    }

    public function countProductsInInvoicesAfterDate(\DateTimeInterface $date): array
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i.name AS productName, MAX(i.description) AS productDescription, MAX(i.price) AS productPrice, COUNT(i.id) AS productCount')
            ->where('i.date >= :date')
            ->setParameter('date', $date)
            ->groupBy('i.name')
            ->orderBy('productCount', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
