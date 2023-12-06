<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Profile;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Adress;
use DateTime;
use Symfony\Component\Validator\Constraints\Date;
use Cocur\Slugify\Slugify;

use function PHPUnit\Framework\isEmpty;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = [];
        for($i = 0; $i <50; $i++){
            $dateU = DateTimeImmutable::createFromMutable($faker->dateTime());
            $user = (new User())->setName($faker->name())
                                ->setPassword(sha1("leMotDePasse"))
                                ->setCreatedAt($dateU);
            $manager->persist($user);

            $dateA = DateTimeImmutable::createFromMutable($faker->dateTime());
            $address = (new Adress())->setStreet($faker->streetName())
                                    ->setCodePostal ($faker->postcode()) 
                                    ->setCity($faker->city()) 
                                    ->setCountry($faker->country()) 
                                    ->setCreatedAt($dateA)
                                    ->setUser($user);
            $dateP = DateTimeImmutable::createFromMutable($faker->dateTime());
                
            $Profile = (new Profile())->setPicture("https://picsum.photos/360/360?image=".$i)
                                    ->setCoverPicture("https://picsum.photos/360/360?image=".($i+100))
                                    ->setDescription($faker->paragraph())
                                    ->setCreatedAt($dateP);
            $user->setProfile($Profile);
            $users[] = $user; 
            $manager->persist($address);
            $manager->persist($Profile);
            $manager->flush();              
        }
        $categories = [];
        for($i=0;$i<5; $i++){
            $dateC = DateTimeImmutable::createFromMutable($faker->dateTime());
            $slugify = new Slugify(); //initialisation de l'objet slugify
            $name = $faker->sentence(2); //le nom de la categorie
            $category = (new Category())->setName($name)
                                        ->setDescription($faker->paragraph())  
                                        ->setImageUrl("https://picsum.photos/360/360?image=".($i+200))
                                        ->setCreatedAt($dateC)
                                        ->setSlug($slugify->slugify($name)); //gestion du slug à partir du nom de la catégorie
            $categories[] = $category;
            $manager->persist($category);
            $manager->flush();
        }
        
        for($i=0;$i<100; $i++){
            $dateArt = DateTimeImmutable::createFromMutable($faker->dateTime());
            $slugify = new Slugify();
            $title = $faker->sentence(3);
            $category = $categories[rand(0,count($categories)-1)]; //on définit la catégorie sélectionné, en avance pour pouvoir la réemployer
            $article = (new Article())->setTitle($title)
                                        ->setContext($faker->text(80))  
                                        ->setImageUrl("https://picsum.photos/360/360?image=".($i+300))
                                        ->setCreatedAt($dateArt)
                                        ->setAuthor($users[rand(0,count($users)-1)])
                                        ->addCategory($category) //on lie une catégorie aléatoire à l'artcile que l'on crée
                                        ->setSlug($slugify->slugify($title));
            $category->addArticle($article);//on lie l'article crée à la catégorie selectionné
            $manager->persist($category); //on update la catégorie en même temps que l'on ajoute les articles dans la BD 
            $manager->persist($article);
            $manager->flush();
        }

        $manager->flush();
    }
}
