<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function findByFilters($marque = null, $mileage = null, $year = null, $price = null)
    {
        $qb = $this->createQueryBuilder('a')
        ->where('a.IsValidated = 1');

        if (!empty($mileage)) {
            $qb->andWhere('a.mileage <= :mileage')
                ->setParameter('mileage', $mileage);
        }

        if (!empty($year)) {
            $qb->andWhere('a.year <= :year')
                ->setParameter('year', $year);
        }

        if (!empty($price)) {
            $qb->andWhere('a.price <= :price')
                ->setParameter('price', $price * 100);
        }

        return $qb->getQuery()->getResult();
    }
}





//    /**
//     * @return Car[] Returns an array of Car objects
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

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

