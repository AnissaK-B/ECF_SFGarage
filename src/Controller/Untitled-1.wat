


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






{% block title %}Garage V.Parrot{% endblock %}
{% block body %}
        <img src="{{asset('assets/images/images (1).jpeg')}}" alt="photo de voiture" class="img-top-pc">
        <main class="main">
                <h2>{{ services[0].getName() }}</h2>
                <span class="trait"></span>
                <div class="texte">
                        <p>{{serviceEmployee[1].getDescription}}</p>
                        <img src="{{asset('assets/images/images (2).jpeg')}}" alt="photo voiture">
                </div>
        <section class="bg-blk">
                <h2>nos prestations</h2>
                <div class="container">
                        <div class="card">
                                <a href="{{path('app_cars')}}">
                                <img src="{{asset('assets/images/images (2).jpeg')}}" alt="photo de voiture">
                                </a>
                        <div class="card-body">
                                <h3 class="card-title">véhicules d'occasions</h3>
                        </div>
                </div>
               

        </div>
        </section>
        <section class="bg-blc">
                <div class="avis">
                <a href="{{path('app_avis')}}" class="btn btn2 key">Cliquez ici pour donner votre avis</a>
                <p>Prenez le temps de nous donner une apreciation !</p>
                </div>
        </section>
        {% for testimonial in intestimonials %}
        {% if testimonial.isActive() %}
        <div class="border rounded w-50 mt-5" style="margin-left: 50%; transform: translateX(-50%)">
                <h5 class="border-bottom p-2">{{testimonial.getName()}}</h5> 
                <p style="padding-left: 3%; padding-top: 2%;">{{testimonial.getTestimonials()}}</p>
                <p class="ps-4 mt-4 text-decoration-underline">{{testimonial.getRate()}}/10</p>
        </div>
        {% endif %}
        {% endfor %}
</main>
{% endblock %}



<section id="section6" class="py-3">
        <div class="row mb-3">
