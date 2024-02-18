<?php
namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/car', name: 'app_car')]
    public function index(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findBy([], ['id' => 'DESC']);
        return $this->render('car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_show')]
    public function show(Car $car): Response
    {
        return $this->render('car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/car/filter', name: 'app_car_filter', methods: ['POST'])]
    public function filter(Request $request, CarRepository $carRepository): JsonResponse
    {
        try {
            // Récupérer les paramètres de la requête AJAX
            $year = $request->request->get('year');
            $price = $request->request->get('price');
            $mileage = $request->request->get('mileage');

            // Utiliser l'EntityManager pour créer la requête
            $queryBuilder = $this->entityManager->createQueryBuilder();
            $queryBuilder
                ->select('car')
                ->from(Car::class, 'car')
                ->where('car.year = :year')
                ->andWhere('car.price = :price')
                ->andWhere('car.mileage = :mileage')
                ->setParameter('year', $year)
                ->setParameter('price', $price)
                ->setParameter('mileage', $mileage);

            $query = $queryBuilder->getQuery();

            // Exécutez la requête et renvoyez les résultats au format JSON
            $filteredCars = $query->getResult();
            return new JsonResponse(['cars' => $filteredCars]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Une erreur s\'est produite lors du filtrage des voitures.']);
        }
    }
}