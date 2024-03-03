<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * @param $drivingSchool
     * @return Client[] Retourne la liste des clients d'une auto école
     * donné en paramètre
     */
    public function findByDrivingSchool($drivingSchool): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.drivingSchool = :drivingSchool')
            ->setParameter('drivingSchool', $drivingSchool)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $drivingSchool
     * @return QueryBuilder Retourne la query utilisée dans le form type
     * pour filtrer la liste des clients en fonction de l'auto école donné en paramètre
     */
    public function queryFindByDrivingSchool($drivingSchool): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.drivingSchool = :drivingSchool')
            ->setParameter('drivingSchool', $drivingSchool);
    }

    public function findByClientNameAndLastName(string $search, $drivingSchool): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.lastname LIKE :lastname OR q.firstname LIKE :firstname')
            ->andWhere('q.drivingSchool = :drivingSchool')
            ->setParameter('lastname', '%' . $search . '%')
            ->setParameter('firstname', '%' . $search . '%')
            ->setParameter('drivingSchool', $drivingSchool)
            ->getQuery()
            ->getResult();

    }

    public function findClientCreatedAfterDate(\DateTimeInterface $date): array {
        return $this->createQueryBuilder('i')
            ->andWhere('i.date >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

}
