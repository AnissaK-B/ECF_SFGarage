<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;
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
        $qb = $this->createQueryBuilder('a');

        if (!empty($marque)) {
            $escapedMarque = htmlspecialchars($marque, ENT_QUOTES, 'UTF-8');
            $qb->andWhere('a.marque LIKE :marque')
                ->setParameter('marque', '%' . $escapedMarque . '%');
        }

        if (!empty($mileage)) {
            if (!is_numeric($mileage) || $mileage < 0) {
                throw new InvalidArgumentException("Valeur de kilométrage invalide");
            }
            $qb->andWhere('a.mileage <= :mileage')
                ->setParameter('mileage', $mileage);
        }

        if (!empty($year)) {
            $currentYear = (int) date('Y');
            if (!is_numeric($year) || $year < 1886 || $year > $currentYear) {
                throw new InvalidArgumentException("Valeur de l'année invalide");
            }
            $qb->andWhere('a.year = :year')
                ->setParameter('year', $year);
        }

        if (!empty($price)) {
            if (!is_numeric($price) || $price < 0) {
                throw new InvalidArgumentException("Valeur du prix invalide");
            }
            $qb->andWhere('a.price <= :price')
                ->setParameter('price', $price * 100);
        }

        return $qb->getQuery()->getResult();
    }
}