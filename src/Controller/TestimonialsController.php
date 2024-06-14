<?php

namespace App\Controller;

use App\Entity\Testimonials;
use App\Form\TestimonialsType;
use App\Repository\TestimonialsRepository;
use App\Repository\ScheduleRepository; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestimonialsController extends AbstractController
{
    #[Route('/testimonials', name: 'app_testimonials')]
    public function index(Request $request, EntityManagerInterface $entityManager, TestimonialsRepository $testimonialsRepository, ScheduleRepository $scheduleRepository): Response
    {
        $schedules = $scheduleRepository->findAll(); 
        $testimonials = new Testimonials();
        $user = $this->getUser();
        $testimonials->setUser($user);
        $testimonials->setApproved(false);
    
        $form = $this->createForm(TestimonialsType::class, $testimonials);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($testimonials);
            $entityManager->flush();

            return $this->redirectToRoute('app_testimonials');
        }

        $approvedTestimonials = $testimonialsRepository->findBy(['approved' => true]);

        return $this->render('testimonials/index.html.twig', [
            'testimonials_form' => $form->createView(),
            'testimonials' => $approvedTestimonials,
            'schedules' => $schedules
        ]);
    }
}
