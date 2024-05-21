<?php

namespace App\Controller;

use App\Form\TestimonialsType;
use App\Repository\CarRepository;
use App\Repository\ScheduleRepository; // Importez le ScheduleRepository
use App\Repository\TestimonialsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarRepository $carRepository, ParameterBagInterface $parameterBagInterface, TestimonialsRepository $testimonialsRepository, ScheduleRepository $scheduleRepository): Response
    {
        $limit = $parameterBagInterface->get('home_car_limit');
        $cars = $carRepository->findBy([], ['id' => 'DESC'], $limit);
        $testimonials = $testimonialsRepository->findAll();
        $schedules = $scheduleRepository->findAll(); // Récupérez les horaires depuis le repository

        return $this->render('page/index.html.twig', [
            'cars' => $cars,
            'testimonials' => $testimonials,
            'schedules' => $schedules, // Passez les horaires au template
        ]);
    }
}