<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;




class UserController extends AbstractController
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/affichageUser' ,name: 'affichage_user')]
    public function affichuser(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();
        //dd($user);
        return $this->render('user/index.html.twig',['users'=>$user]);
    }

    #[Route('/recherchUser' ,name: 'recherch_user')]
    public function rechercheuser(Request $request ,UserRepository $userRepository): Response
    {
        
        $username = $request->get('username');
        $user = $userRepository->findUser($username);
        
        //dd($user);
        return $this->render('user/index.html.twig',['users'=>$user]);
    }


    #[Route('createUser' , name:'create_user')]
    public function createVoitureAction(Request $request, SluggerInterface $slugger,EntityManagerInterface $manager):Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

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
                        $this->getParameter('directory_users'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImage($newFilename);
                $hashmot = $this->hasher->hashPassword($user,$user->getPassword());
                $user->setPassword($hashmot);
            }

            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre User a ete créé avec succés'
            );
            return $this->redirectToRoute('affichage_user');
        }
        return $this->render('user/gestion.html.twig', ['form'=>$form->createView()]);
    }


    #[Route('editUser/{id}' , name:'edit_user')]
    
    public function editUserAction(int $id,UserRepository $userRepository,Request $request, SluggerInterface $slugger,EntityManagerInterface $manager):Response
    {
        $user = $userRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

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
                        $this->getParameter('directory_users'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImage($newFilename);
                $hashmot = $this->hasher->hashPassword($user,$user->getPassword());
                $user->setPassword($hashmot);
                
                
            }

            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'votre Utilisatuer a ete Modifier avec succés'
            );
            return $this->redirectToRoute('affichage_user');
        }
        return $this->render('user/gestion.html.twig', ['form'=>$form->createView()]);
    }

    #[Route('deleteUser/{id}' ,name:'delete_user')]
    public function deleteUserAction(int $id,UserRepository $userRepository,EntityManagerInterface $manager):Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);
        $manager->remove($user);
        $manager->flush();
        $this->addFlash(
            'success',
            'votre Utilisatuer a ete Supprimer avec succés'
        );
        return $this->redirectToRoute('affichage_user');
    }
}
