<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountEditFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @IsGranted("ROLE_USER")
 */

class AccountController extends BaseController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index()
    {

        //dd($this->getUser()->getCompany());
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/edit-account/{id}", name="app_edit_account")
     */
    public function edit(EntityManagerInterface $em, $id, Request $request)
    {
        $repository = $em->getRepository(User::class);
        $user = $repository->find($id);

        $form = $this->createForm(AccountEditFormType::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_account');

        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
