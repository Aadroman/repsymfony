<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Faker\Factory;

class TestController extends AbstractController
{
    #[Route('/test/twig', name: 'app_test_twig')]
    public function index(): Response
    {   
    
        //on utilise la Faker\Factory pour créer un Faker version française
        $faker = Factory::create('fr_FR');
        //on crée un tableau de user 
        $users = [];
        for ($i=0;$i<9;$i++){
            $user=[ //maintenant l'objet user est un tableau associatif
                'name'=>$faker->name(),
                'email'=>$faker->email(),
                'age'=>$faker->randomNumber(2,false),
                'adress'=>[
                    'street'=>$faker->streetName(),
                    'code_postal'=>$faker->postcode(),
                    'city'=>$faker->city(),
                    'country'=>$faker->country(),
                ],
                'cover' => $faker->imageUrl(50,50,'humans',true,true,'jpg'),
                'picture' => $faker->imageUrl(360,360,'animals',true,'dogs',true,'jpg'),
                'createdAt'=>$faker->date("")
            ];
            $users[$i] = $user; //on génère des noms
        }
        //on appelle la vue en transférant les paramètres
        return $this->render('test/index.html.twig', [
            'title' => 'Page accueil',
            'users' => $users,
        ]);
    }
}
