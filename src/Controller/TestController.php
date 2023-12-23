<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManager;
use App\Repository\ModelRepository;
use App\Repository\VoitureRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestController extends AbstractController
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/ff',name: 'fetch_categ')]
    public function fetchCateg(EntityManagerInterface $manager)
    {
       /* $user = new User();
        $user->setEmail("oussama@gmail")
            ->setRoles(['ROLE_USER']);
            
        $hashmot = $this->hasher->hashPassword($user,'123');
        $user->setPassword($hashmot);
        $manager->persist($user);
        $manager->flush();

        return new Response('id = '.$user->getId());*/
    }
    #[Route('/',name: 'home_rout')]
    public function home(): Response
    {
        return $this->render('hom.html.twig');
    }

   

}
