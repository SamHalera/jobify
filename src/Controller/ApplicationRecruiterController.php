<?php

namespace App\Controller;

use App\Entity\Application;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ApplicationRecruiterController extends AbstractController
{
    /**
     * @Route("/recruiter/applications/job/{id}", name="app_applications_list")
     */
    public function index(EntityManagerInterface $em, JobOfferRepository $jobOfferRepository, $id)
    {

        //$repository = $em->getRepository(Application::class);
        $jobOffer = $jobOfferRepository->find($id);

        /*$applications = $repository->findBy(
            [
                'jobOffer'=> $id
            ]);

        */

        return $this->render('recruiter/applications_list.html.twig', [
            //'applications' => $applications,
            'jobOffer' => $jobOffer
        ]);
    }
    
    /**
     * @Route("/recruiter/applications/{id}/view", name="app_application_view")
     */
    public function view(EntityManagerInterface $em, $id)
    {
        return $this->render('recruiter/application_view.html.twig', [
            //'controller_name' => 'ApplicationController',
        ]);
    }


    /**
     * @Route("/recruiter/applications/{id}/isDeleted", name="app_application_isDeleted")
     *
     * @param [type] $id
     * @return boolean
     */
    public function isDeleted(EntityManagerInterface $em, Request $request, $id)
    {
        $repository = $em->getRepository(Application::class);
        /**
         * @var Application $application
         */
        $application = $repository->find($id);

        $application->setIsDeleted(true);

        $em->persist($application);
        $em->flush($application);

        $request->getSession()->getFlashBag()->add('success', 'La canddiature a bien été supprimée');
        return $this->redirectToRoute('app_applications_list', ['id' => $application->getJobOffer()->getId()]);

    }
}
