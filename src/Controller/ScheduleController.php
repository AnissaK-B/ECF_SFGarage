<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    #[Route('/schedule', name: 'app_schedule')]

    public function index(ScheduleRepository $scheduleRepository): Response
    {
        $schedule = $scheduleRepository->findAll();

        return $this->render('schedule/index.html.twig', [
            'schedule' => $schedule,
        ]);
    }
}
