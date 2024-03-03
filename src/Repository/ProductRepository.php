<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findProductByNameAndDescription(string $search, $drivingSchool): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.productName LIKE :productName OR q.productDescription LIKE :productDescription')
            ->andWhere('q.drivingSchool = :drivingSchool')
            ->setParameter('productName', '%' . $search . '%')
            ->setParameter('productDescription', '%' . $search . '%')
            ->setParameter('drivingSchool', $drivingSchool)
            ->getQuery()
            ->getResult();
    }
}
