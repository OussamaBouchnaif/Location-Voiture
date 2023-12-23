<?php

namespace App\Controller;

use App\Repository\FactureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FactureController extends AbstractController
{
    #[Route('/facture', name: 'app_facture')]
    public function index(): Response
    {
        return $this->render('facture/index.html.twig', [
            'controller_name' => 'FactureController',
        ]);
    }

    #[Route('affichageFacture' ,name:'affichage_facture')]
    public function affichage_facture(FactureRepository $repository): Response
    {
        $facture = $repository->afficherFactures(); 
        //dd($facture);
        return $this->render('facture/index.html.twig',['facture'=> $facture]);
    }
}
