<?php

namespace App\Controller;

use App\Entity\Testimonials;
use App\Form\TestimonialsType;
use App\Repository\TestimonialsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestimonialsController extends AbstractController
{
     
    #[Route('/testimonials', name: 'app_testimonials')]
    public function index(Request $request, EntityManagerInterface $entityManager, Security $security ,TestimonialsRepository$testimonialsRepository ): Response
    {
        $testimonials= new Testimonials();
        $user =$security->getUser();
        $testimonials->setUser($user);
        $testimonials->setApproved(false);

        $form =$this->createForm(TestimonialsType::class, $testimonials );
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            try {
                $entityManager->persist($testimonials);
                $entityManager->flush();
    
                $this->addFlash('success', 'Nous avons pris en compte votre avis');
                return $this->redirectToRoute('home_');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Une erreur est survenue : ' . $e->getMessage());
            }

            $testimonials = $testimonialsRepository->findAll();


      
        }

        return $this->render('testimonials/index.html.twig', [
    
            'testimonials_form' => $form->createView(), 
            
        ]);



        
    }

    






}

