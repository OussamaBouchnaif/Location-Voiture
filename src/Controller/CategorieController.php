<?php

namespace App\Controller;

use PhpParser\Node\Name;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }


    #[Route('/addCategorie' ,name:'add_categorie')]
    public function addCategorie(Request $request,EntityManagerInterface $manager): Response
    {
        $libelle = $request->get('libelle');
        $categorie = new Categorie();
        $categorie->setLibelle($libelle);
        $manager->persist($categorie);
        $manager->flush();

        $this->addFlash(
            'success',
            'votre Categorie a été bien Ajouter'
        );
        return $this->redirectToRoute('affichage_Voiture');

    }
}
