<?php


namespace App\Controller;

use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class JobOfferRecruiterController extends AbstractController{

    /**
     * @Route("recruiter/joboffer/new", name="app_recruiter_joboffer_new")
     */
    public function new(EntityManagerInterface $em){

        $jobOffer = new JobOffer();

        $title = "Webdesigner Senior";
        $contentMisison = "This is the mission";
        $contentRequirements = "These are the requirements";

        $jobOffer
            ->setTitle($title."-".rand(100,990))
            ->setContentMission($contentMisison)
            ->setContentRequirements($contentRequirements)
            ->setSlug("webdeisgner-".rand(100,999));
        
        //publish some job offers randomly
        
        if(rand(1,10) > 2){
            $jobOffer->setPublishedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }

        $em->persist($jobOffer);
        $em->flush();

        return $this->redirectToRoute('app_recruiter_joboffers_list');
    }

    /**
     * @Route("recruiter/jobs/list", name = "app_recruiter_jobs_list")
     */
    public function list(EntityManagerInterface $em){

        $repository = $em->getRepository(JobOffer::class);

        
        $jobsList = $repository->findAll();

        return $this->render("recruiter/jobs_list.html.twig",[
            'jobsList' => $jobsList
        ]);
    }

}