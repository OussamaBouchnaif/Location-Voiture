<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/affichageClient' , name: 'affichage_Client')]
    public function affichC(ClientRepository $clientRepository) 
    {
        $client = $clientRepository->findAll();
        

        return $this->render('client/index.html.twig' ,['client'=>$client]);
    }

    #[Route('/createClient', name: 'create_client')]
    public function createAction(Request $request,EntityManagerInterface $manager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $client = $form->getData();
            $manager->persist($client);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre client a ete créé succés'
            );
            
            return $this->redirectToRoute('affichage_Client');
        }
        return $this->render('client/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/editClient/{id}",name: "edit_client")]
    public function editAction(int $id,ClientRepository $clientRepository,Request $request,EntityManagerInterface $manager):Response
    {
        
        $client = $clientRepository->findOneBy(array('id' => $id));
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $client = $form->getData();
            $manager->persist($client);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre client a ete modifier succés'
            );
            
            return $this->redirectToRoute('affichage_Client');
        }
        return $this->render('client/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
        
    }

    #[Route('/deleteClient/{id}' , name : 'delete_client')]
    public function deleteAction(EntityManagerInterface $manager ,int $id,ClientRepository $clientRepository):Response
    {
        $user = $clientRepository->findOneBy(["id" => $id ]);
        $manager->remove($user);
        $manager->flush();
        $this->addFlash(
            'success',
            'votre client a été bien supprimer'
        );
        return $this->redirectToRoute('affichage_Client');
    }

    #[Route('/recherchClient',name:'recherch_client')]
    public function recherchClientAction(ClientRepository $clientRepository, Request $request):Response
    {
        $username = $request->get('nomprenom');
        $clients = $clientRepository->findClient($username);
        return $this->render('client/index.html.twig' ,['client'=>$clients]);
        //dd($clients);
    }

}
