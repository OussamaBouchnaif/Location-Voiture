<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Form\AgenceType;
use App\Repository\AgenceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgenceController extends AbstractController
{
    #[Route('/agence', name: 'app_agence')]
    public function index(): Response
    {
        return $this->render('agence/index.html.twig', [
            'controller_name' => 'AgenceController',
        ]);
    }
    #[Route('/affichageAgence' ,name: 'affichage_Agence')]
    public function affichAgence(AgenceRepository $agenceRepository):Response
    {
        $agence = $agenceRepository->findAll();
        //dd($agence);
        return $this->render('agence/index.html.twig',['agence' => $agence]);
    }

    #[Route('/createAgence' , name: 'create_Agence')]
    public function createAgence(Request $request,EntityManagerInterface $manager):Response
    {
        $agence = new Agence();
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $agence = $form->getData();
            $manager->persist($agence);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre Agence a ete créé avec succés'
            );
            return $this->redirectToRoute('affichage_Agence');
        }
        return $this->render('agence/ajouter.html.twig', ['form'=>$form->createView()]);

    }

    #[Route('editAgence/{id}' , name:'edit_agence')]
    public function editagence(int $id,AgenceRepository $agenceRepository, EntityManagerInterface $manager,Request $request):Response
    {
        $agence = $agenceRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $agence = $form->getData();
            $manager->persist($agence);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre Agence a ete Modifier avec succés'
            );
            return $this->redirectToRoute('affichage_Agence');
        }
        return $this->render('agence/modifier.html.twig', ['form'=>$form->createView()]);
    }

    #[Route('deleteAgence/{id}' , name:'delete_agence')]
    public function deleteAgence(int $id,EntityManagerInterface $manager,AgenceRepository $agenceRepository):Response
    {
        $agence = $agenceRepository->findOneBy(['id' => $id]);
        $manager->remove($agence);
        $manager->flush();
        $this->addFlash(
            'success',
            'votre Agence a ete Supprimer avec succés'
        );
        return $this->redirectToRoute('affichage_Agence');
    }

    #[Route('/recherchAgence',name:'recherch_agence')]
    public function recherchClientAction(AgenceRepository $agenceRepository, Request $request):Response
    {
        $value = $request->get('value');
        $agence = $agenceRepository->findAgence($value);
        return $this->render('agence/index.html.twig' ,['agence'=>$agence]);
        //dd($clients);
    }
}
