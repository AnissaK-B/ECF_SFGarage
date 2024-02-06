<?php

namespace App\Controller;
use App\Entity\car;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findBy([], ['id'=>'DESC' ]);
        return $this->render('car/index.html.twig', [
          
            'cars'=> $cars,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_show')]
    public function show(Car $car): Response
    {
     
        return $this->render('car/show.html.twig', [
          
            'car'=> $car,
        ]);
    }
    
    
   public function filter(Request $request):JsonResponse
   {
       // Récupérer les paramètres de la requête AJAX
       $minYear = $request->request->get('minYear');
       $maxYear = $request->request->get('maxYear');
       $minPrice = $request->request->get('minPrice');
       $maxPrice = $request->request->get('maxPrice');
       $minKm = $request->request->get('minKm');
       $maxKm = $request->request->get('maxKm');

       // Construire la requête en fonction des filtres
       $query = $this->getDoctrine()
           ->getRepository(Car::class)
           ->createQueryBuilder('car')
           ->where('car.year BETWEEN :minYear AND :maxYear')
           ->andWhere('car.price BETWEEN :minPrice AND :maxPrice')
           ->andWhere('car.kilometers BETWEEN :minKm AND :maxKm')
           ->setParameter('minYear', $minYear)
           ->setParameter('maxYear', $maxYear)
           ->setParameter('minPrice', $minPrice)
           ->setParameter('maxPrice', $maxPrice)
           ->setParameter('minKm', $minKm)
           ->setParameter('maxKm', $maxKm)
           ->getQuery();

       $cars = $query->getResult();

       // Retourner les résultats au format JSON
       return new JsonResponse(['cars' => $cars]);
   }

   

}







