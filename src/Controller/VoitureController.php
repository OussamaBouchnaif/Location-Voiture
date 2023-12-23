<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'app_voiture')]
    public function index(): Response
    {
        return $this->render('voiture/index.html.twig', [
            'controller_name' => 'VoitureController',
        ]);
    }

    #[Route('/affichageVoiture' , name: 'affichage_Voiture')]
    public function affichageVoiture(VoitureRepository $voitureRepository): Response
    {
        $voiture = $voitureRepository->findAll();
        //dd($voiture); 
        $var = 'afficher';
        return $this->render('voiture/index.html.twig',['voiture'=>$voiture,'var' => $var]);
    }


    #[Route('createVoiture' , name:'create_Voiture')]
    public function createVoitureAction(Request $request, SluggerInterface $slugger,EntityManagerInterface $manager):Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $voiture = $form->getData();

            $brochureFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $voiture->setImage($newFilename);
                
            }

            $manager->persist($voiture);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre Voiture a ete créé avec succés'
            );
            return $this->redirectToRoute('affichage_Voiture');
        }
        return $this->render('voiture/gestion.html.twig', ['form'=>$form->createView()]);
    }

    #[Route('editVoiture/{id}' , name:'edit_voiture')]
    public function editVoitureAction(int $id,VoitureRepository $voitureRepository,Request $request, SluggerInterface $slugger,EntityManagerInterface $manager):Response
    {
        $voiture = $voitureRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $voiture = $form->getData();

            $brochureFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $voiture->setImage($newFilename);
                
            }

            $manager->persist($voiture);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre Voiture a ete Modifier avec succés'
            );
            return $this->redirectToRoute('affichage_Voiture');
        }
        return $this->render('voiture/gestion.html.twig', ['form'=>$form->createView()]);
    }

    #[Route('deleteVoiture/{id}' , name:'delete_voiture')]
    public function deleteVoitureAction(int $id,VoitureRepository $voitureRepository,EntityManagerInterface $manager) : Response
    {
        $voiture = $voitureRepository->findOneBy(['id'=>$id]);
        $manager->remove($voiture);
        $manager->flush();
        $this->addFlash(
            'success',
            'votre Voiture a ete Supprimer avec succés'
        );
        return $this->redirectToRoute('affichage_Voiture');
    }

    #[Route('/recherchVoiture',name:'recherch_voiture')]
    public function recherchClientAction(VoitureRepository $voitureRepository, Request $request):Response
    {
        $libelle = $request->get('libelle');
        $voiture = $voitureRepository->findVoiture($libelle);
        $var = 'recherch';
        return $this->render('voiture/index.html.twig' ,['voiture'=>$voiture,'var' => $var]);
        //dd($voiture);
    }
    
}
