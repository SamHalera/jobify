<?php

namespace App\Controller;

use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JobOfferController extends AbstractController
{

    /**
     * @Route("/jobs", name="app_jobs_list")
     */
    public function JobOffersIndex(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(JobOffer::class);

        $jobList = $repository->findBy(
            [
                'isFilled' => false,
                'isPublished' => true
            ],
            [
                'publishedAt' => 'DESC'
            ]
        );
        return $this->render('job_offers/list.html.twig', 
            [
                'jobList' => $jobList
            ]
        );
    }

    /**
     * @Route("/job/{slug}", name="app_job_view")
     */
    public function JobOfferView(EntityManagerInterface $em, $slug)
    {
        $repository = $em->getRepository(JobOffer::class);

        $job = $repository->findOneBy(['slug' => $slug]);

        return $this->render('job_offers/view.html.twig', [
            'job' => $job
        ]);
    }
}


