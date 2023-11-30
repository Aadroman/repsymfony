<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Profile;
use App\Entity\Tp4Bd;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Adress;
use DateTime;
use Symfony\Component\Validator\Constraints\Date;
use Cocur\Slugify\Slugify;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = [];
        for($i = 0; $i <50; $i++){
            $dateU = DateTimeImmutable::createFromMutable($faker->dateTime());
            $user = (new Tp4Bd())->setTp4Bd($faker->name())
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
            $category = (new Category())->setName($faker->sentence(2))
                                        ->setDescription($faker->paragraph())  
                                        ->setImageUrl("https://picsum.photos/360/360?image=".($i+200))
                                        ->setCreatedAt($dateC);
            $categories[] = $category;
            $manager->persist($category);
            $manager->flush();
        }
        
        for($i=0;$i<100; $i++){
            $dateArt = DateTimeImmutable::createFromMutable($faker->dateTime());
            $slugify = new Slugify();
            $title = $faker->sentence(3);
            $article = (new Article())->setTitle($title)
                                        ->setContext($faker->text(80))  
                                        ->setImageUrl("https://picsum.photos/360/360?image=".($i+300))
                                        ->setCreatedAt($dateArt)
                                        ->setAuthor($users[rand(0,count($users)-1)])
                                        ->addCategory($categories[rand(0,count($categories)-1)])
                                        ->setSlug($slugify->slugify($title));
            $manager->persist($article);
            $manager->flush();
        }

        $manager->flush();
    }
}
