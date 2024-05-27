<?php
namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Repository\ScheduleRepository;
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
    public function index(CarRepository $carRepository, ScheduleRepository $scheduleRepository, Request $request): Response
    {
        $marque = $request->query->get('marque');
        $kilometre = $request->query->get('mileage');
        $annee = $request->query->get('year');
        $price = $request->query->get('price');

        if (!empty($marque) || !empty($kilometre) || !empty($annee) || !empty($price)) {
            $cars = $carRepository->findByFilters($marque, $kilometre, $annee, $price);
        } else {
            $cars = $carRepository->findAll();
        }

        $schedules = $scheduleRepository->findAll();

        return $this->render('car/index.html.twig', [
            'cars' => $cars,
            'schedules' => $schedules,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_show')]
    public function show(Car $car, ScheduleRepository $scheduleRepository): Response
    {
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
            $marque = $request->query->get('marque');
            $kilometre = $request->query->get('mileage');
            $annee = $request->query->get('year');
            $price = $request->query->get('price');

            $filteredCars = $carRepository->findByFilters($marque, $kilometre, $annee, $price);

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

            return new JsonResponse(['cars' => $carData]);

        } catch (\InvalidArgumentException $exception) {
            $this->addFlash('danger', $exception->getMessage());
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            $this->addFlash('danger', 'Une erreur s\'est produite lors du filtrage des voitures.');
            return new JsonResponse(['error' => 'Une erreur s\'est produite lors du filtrage des voitures.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
