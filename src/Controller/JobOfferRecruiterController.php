<?php


namespace App\Controller;

use App\Entity\Application;
use App\Entity\JobOffer;
use App\Entity\User;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class JobOfferRecruiterController extends AbstractController{

    /**
     * @Route("recruiter/jobs/new", name="app_recruiter_joboffer_new")
     * @IsGranted("ROLE_RECRUITER")
     */
    public function new(EntityManagerInterface $em, Request $request){

        
        $jobOffer = new JobOffer();

        $title = "Webdesigner Senior";
        $contentMisison = "This is the mission";
        $contentRequirements = "These are the requirements";

        $jobOffer
            ->setTitle($title."-".rand(100,990))
            ->setContentMission($contentMisison)
            ->setContentRequirements($contentRequirements)
            ->setAuthor($this->getUser())
            ->setImageFilename('dev1.jpg');
        
        $application1 = new Application();
        $application2 = new Application();
        $application1
            ->setApplicantName('Johnatan Blaise')
            ->setMotivationalMessage('Bonjour, je suis intéressé par votre offre! Merci de me contacter!')
            ->setJobOffer($jobOffer);
        $application2
            ->setApplicantName('Patrice Low')
            ->setMotivationalMessage('Bonjour, je suis intéressé par votre offre! Je suis très motivé hein!')
            ->setJobOffer($jobOffer);
        
        $em->persist($jobOffer);
        $em->persist($application1);
        $em->persist($application2);
        $em->flush();

        return $this->redirectToRoute('app_recruiter_jobs_list');
    }

    /**
     * @Route("/recruiter/jobs/edit/{id}", name="app_recruiter_job_edit")
     * @IsGranted("MANAGE", subject="jobOffer")
     *
     */
    public function edit(JobOffer $jobOffer)
    {        
        //check the VOTER SYSTEM => see in Security/voter
        //$this->denyAccessUnlessGranted('MANAGE', $jobOffer);
        
        dd($jobOffer);
    
    }
    /**
     * @Route("recruiter/jobs/list", name= "app_recruiter_jobs_list")
     */
    public function list(EntityManagerInterface $em, Request $request){


        $q = $request->query->get('q');

        $repository = $em->getRepository(JobOffer::class);

        
        $jobsList = $repository->findAllWithSearch($q);

        return $this->render("recruiter/jobs_list.html.twig",[
            'jobsList' => $jobsList
        ]);
    }

    /**
     * @Route("recruiter/jobs/{id}", name="app_recruiter_job_show")
     */
    public function show(EntityManagerInterface $em, $id){

        $repository = $em->getRepository(JobOffer::class);

        /**@var JobOffer $jobOffer */
        $jobOffer = $repository->findOneBy(['id' => $id]);

        if(!$jobOffer){
            throw $this->createNotFoundException(\sprintf('Aucune offre d\'emploi avec l\'id %s', $id)); 
        }

       

        return $this->render('recruiter/job_view.html.twig', [
            'jobOffer' => $jobOffer
        ]);
    }

    /**
     * @Route("recruiter/jobs/{id}/isFilled", name="app_recruiter_job_isFilled")
     */
    public function isFilled(EntityManagerInterface $em, $id){

        $repository = $em->getRepository(JobOffer::class);
        $jobOffer = $repository->find($id);

        if($jobOffer->getIsFilled == true){
            $jobOffer->setIsFilled(false);
            
        } else{
            $jobOffer->setIsFilled(true);
        }
        $em->persist($jobOffer);
        $em->flush();

        return $this->redirectToRoute('app_recruiter_job_show', ['id' => $id]);

    }

    /**
     * 
     * @Route("recruiter/jobs/{id}/IsPublished", name="app_admin_job_offer_published")
     */
    public function isPublished($id, Request $request, EntityManagerInterface $em){
        
        $repository = $em->getRepository(JobOffer::class);
        $jobOffer = $repository->find($id);

        if($jobOffer->getIsPublished() == true){
            $jobOffer->setIsPublished(false);
            //$jobOffer->setIsFilled(false);
            $jobOffer->setPublishedAt(NULL);
            $request->getSession()->getFlashBag()->add('success', 'L\'annonce a bien été retirée');
        } else {
            $jobOffer->setIsPublished(true);
            //$jobOffer->setIsFilled(true);
            $jobOffer->setPublishedAt(new \DateTime());
            $request->getSession()->getFlashBag()->add('success', 'L\'annonce a bien été pubbliée');
        }
        
        $em->persist($jobOffer);
        $em->flush();
        
        
        
        return $this->redirectToRoute('app_recruiter_job_show', ['id' => $id]);
        
    }
    

}