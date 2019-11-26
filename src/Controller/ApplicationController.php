<?php

namespace App\Controller;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationController extends AbstractController
{
    /**
     * @Route("/applications/job/{id}", name="app_applications_list")
     */
    public function index(EntityManagerInterface $em, $id)
    {

        $repository = $em->getRepository(Application::class);

        $applications = $repository->findBy(
            [
                'jobOffer'=> $id
            ]);

        

        return $this->render('application/index.html.twig', [
            'applications' => $applications,
            
        ]);
    }
    
    /**
     * @Route("/applications/{id}/view", name="app_application_view")
     */
    public function view(EntityManagerInterface $em, $id)
    {
        return $this->render('application/view.html.twig', [
            'controller_name' => 'ApplicationController',
        ]);
    }
}
