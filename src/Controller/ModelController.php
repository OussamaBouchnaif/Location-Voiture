<?php

namespace App\Controller;

use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModelController extends AbstractController
{
    #[Route('/model', name: 'app_model')]
    public function index(): Response
    {
        return $this->render('model/index.html.twig', [
            'controller_name' => 'ModelController',
        ]);
    }
    #[Route('/addModel' ,name:'add_model')]
    public function addCategorie(Request $request,EntityManagerInterface $manager): Response
    {
        $libelle = $request->get('libelle');
        $model = new Model();
        $model->setLibelle($libelle);
        $manager->persist($model);
        $manager->flush();

        $this->addFlash(
            'success',
            'votre Model a été bien Ajouter'
        );
        return $this->redirectToRoute('affichage_Voiture');

    }
}
