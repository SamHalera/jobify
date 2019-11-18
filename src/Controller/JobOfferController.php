<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JobOfferController extends AbstractController
{

    /**
     * @Route("/jobs", name="app_jobs_list")
     */
    public function JobOffersIndex()
    {

        return $this->render('job_offers/list.html.twig');
    }
}


