<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }


    #[Route('/affichageReservation' ,name: 'affichage_reservation')]
    public function affichageReservation(ReservationRepository $reservationRepository): Response
    {
        $reservation = $reservationRepository->findAll();
        $var = 'afficher';
        return $this->render('reservation/index.html.twig' ,['reservation' => $reservation , 'var'=>$var ]);
    }

    #[Route('createReservation' ,name:'create_reservation')]
    public function createReservation(Request $request,EntityManagerInterface $manager,  ReservationRepository $reservationRepository)
    {
        $reservation = new Reservation();
        $facture = new Facture();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $reservation = $form->getData();
            $manager->persist($reservation);
            $manager->flush();

            $facture->setReservation($reservation);
            $facture->setTotal($reservation->calculerDuree($reservation->getDateDepart(), $reservation->getDateRetour())*$reservation->getPrix());
            $manager->persist($facture);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'votre Reservation a été creé avec success'
            );
            return $this->redirectToRoute('affichage_reservation');
        }
        return $this->render('reservation/gestion.html.twig',['form'=> $form->createView()]);
    }
   /* #[Route('createReservationid/{id}' ,name:'create_reservationid')]
    public function createReservationid(int $id,Request $request,EntityManagerInterface $manager,  ReservationRepository $reservationRepository)
    {
        $reservation = $reservationRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $reservation = $form->getData();
            $manager->persist($reservation);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre Reservation a été creé avec success'
            );
            return $this->redirectToRoute('affichage_reservation');
        }
        return $this->render('reservation/gestion.html.twig',['form'=> $form->createView()]);
    }*/
    #[Route('editReservation/{id}' ,name:'edit_reservation')]
    public function editReservation(int $id,  Request $request,EntityManagerInterface $manager,  ReservationRepository $reservationRepository)
    {
        $reservation = $reservationRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $reservation = $form->getData();
            $manager->persist($reservation);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre Reservation a été Modifier avec success'
            );
            return $this->redirectToRoute('affichage_reservation');
        }
        return $this->render('reservation/gestion.html.twig',['form'=> $form->createView()]);
    }
    #[Route('deleteReservation/{id}' ,name:'delete_reservation')]
    public function deleteReservation(int $id, EntityManagerInterface $manager,  ReservationRepository $reservationRepository)
    {
        $reservation = $reservationRepository->findOneBy(['id'=>$id]);
        $manager->remove($reservation);
        $manager->flush();
        $this->addFlash(
            'success',
            'votre Reservation a été Supprimer avec success'
        );
        return $this->redirectToRoute('affichage_reservation');
    
    }

    #[Route('/recherchReservation',name:'recherch_reservation')]
    public function recherchClientAction(ReservationRepository $reservationRepository, Request $request):Response
    {
        $value = $request->get('value');
        $reservation = $reservationRepository->findReservation($value);
        $var = 'recherch';
        return $this->render('reservation/index.html.twig' ,['reservation'=>$reservation , 'var' => $var]);
        //dd($reservation);
    }

}
