<?php
namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Repository\ScheduleRepository; // Importez le ScheduleRepository
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
    public function index(CarRepository $carRepository,  ScheduleRepository $scheduleRepository): Response
    {
        $cars = $carRepository->findAll();
        $schedules = $scheduleRepository->findAll(); // Récupérez les horaires depuis le repository
        return $this->render('car/index.html.twig', [
            'cars' => $cars,
            'schedules' => $schedules, 
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_show')]
    public function show(Car $car,  ScheduleRepository $scheduleRepository): Response
    {
        // Récupérer les horaires spécifiques pour cette voiture
        $schedules = $scheduleRepository->findAll();

    return $this->render('car/show.html.twig', [
        'car' => $car,
        'schedules' => $schedules, 
    ]);
}


    #[Route('/car/filter', name: 'app_car_filter', methods: ['GET'])]
    public function filter(Request $request, CarRepository $carRepository): JsonResponse
    {
        try {
            $year = $request->query->get('year');
            $price = $request->query->get('price');
            $mileage = $request->query->get('mileage');
            $marque = $request->query->get('marque');
           

            $queryBuilder = $carRepository->createQueryBuilder('car');

                if ($year) {
                    $queryBuilder->andWhere('car.year = :year')
                                ->setParameter('year', $year);
                }
                if ($price) {
                    $queryBuilder->andWhere('car.price <= :price')
                                ->setParameter('price', $price);
                }
                if ($mileage) {
                    $queryBuilder->andWhere('car.mileage <= :mileage')
                                ->setParameter('mileage', $mileage);
                }
                if ($marque) {
                    $queryBuilder->andWhere('car.marque LIKE :marque')
                                ->setParameter('marque', '%' . $marque . '%');
                }

            $filteredCars = $queryBuilder->getQuery()->getResult();

            $carData = [];
            foreach ($filteredCars as $car) {
                $carData[] = [
                    'image' => $car->getImage(),
                    'marque' => $car->getMarque(),
                    'mileage' => $car->getMileage(),
                    'year' => $car->getYear(),
                    'price' => $car->getPrice(),
                    'url' => $this->generateUrl('app_car_show', ['id' => $car->getId()])
                ];
            }

            return new JsonResponse(['car' => $carData]);

        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Une erreur s\'est produite lors du filtrage des voitures.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
