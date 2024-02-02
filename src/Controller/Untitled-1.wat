


carcontroller.php


<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Repository\ScheduleRepository;
use App\Repository\ServiceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(
        CarRepository $carRepository,
        ScheduleRepository $schedulesRepository, // Correction: Assurez-vous que le nom du repository est correct
        ServiceRepository $servicesRepository, // Correction: Assurez-vous que le nom du repository est correct
        PaginatorInterface $paginatorInterface,
        Request $request
    ): Response {
        $marque = $request->query->get('marque');
        $mileage = $request->query->get('mileage');
        $year = $request->query->get('year');
        $price = $request->query->get('price');

        if (!empty($marque) || !empty($mileage) || !empty($year) || !empty($price)) {
            $cars = $carRepository->findByFilters($marque, $mileage, $year, $price);
        } else {
            $cars = $carRepository->findAll();
        }

        return $this->render('cars/index.html.twig', [
            'controller_name' => 'CarsController',
            'schedule' => $schedulesRepository->findAll(),
            'marque' => $marque,
            'mileage' => $mileage,
            'price' => $price,
            'cars' => $cars,
            'services' => $servicesRepository->findAll()
        ]);
    }

    
    #[Route('/car', name: 'app_car')]
    public function getFilteredCar(
        ScheduleRepository $schedulesRepository,
        CarRepository $carsRepository,
        PaginatorInterface $paginatorInterface,
        ServiceRepository $servicesRepository,
        Request $request
    ): JsonResponse {
        $marque = $request->query->get('marque');
        $mileage = $request->query->get('mileage');
        $year = $request->query->get('year');
        $price = $request->query->get('price');
    
        $filteredCars = $carsRepository->findByFilters($marque, $mileage, $year, $price); 
        $filteredCars = $paginatorInterface->paginate($filteredCars, $request->query->getInt('page', 1), 6);
        $filteredCars->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        $filteredCars->setUsedRoute("app_car");

        $paginationContext = $paginatorInterface->paginate($filteredCars, $request->query->getInt('page', 1), 6);

        $twig = $this->container->get('twig');
        $paginationString = $twig->render($filteredCars->getTemplate(), ['pagination' => $paginationContext]);  

        $filteredData = [
            "car" => [],
            "pagination" => $paginationString,
        ];

        foreach ($paginationContext as $car) {
            $filteredData["car"][] = [
                'id' => $car->getId(),
                'marque' => $car->getMarque(),
                'mileage' => $car->getMileage(),
                'annee' => $car->getYear(),
                'price' => $car->getPrice(),
                'image' => $car->getImage(),
                'url' => $this->generateUrl('app_formulaire_from_card', [
                    'marque' => $car->getMarque(),
                    'price' => $car->getPrice(),
                ])
            ];
        }
        
        return new JsonResponse($filteredData);
    }
}