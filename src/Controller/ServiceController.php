<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(ServiceRepository $serviceRepository, ScheduleRepository $scheduleRepository): Response
    {
        $services = $serviceRepository->findAll();
        $schedules = $scheduleRepository->findAll(); // Utilisation de $schedules au lieu de $schedule
        
        return $this->render('service/index.html.twig', [
            'services' => $services,
            'schedules' => $schedules, // Utilisation de 'schedules' au lieu de 'schedule'
        ]);
    }
}
