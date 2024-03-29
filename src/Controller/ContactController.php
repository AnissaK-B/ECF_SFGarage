<?php

namespace App\Controller;

use App\Entity\Formulaire;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $formulaire =new Formulaire();
        $form =$this->createForm(ContactFormType::class, $formulaire);
        $form->handleRequest($request);


        
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
