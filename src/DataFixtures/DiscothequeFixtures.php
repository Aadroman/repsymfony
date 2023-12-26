<?php

namespace App\DataFixtures;

use App\Entity\Artiste;
use App\Entity\Chanson;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTimeImmutable;

class DiscothequeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $typesTitle=["Pop","Rock","Hip-Hop","Jazz","Classique"];
        $types=[];
        $max = count($typesTitle);
        for($i=0;$i<$max;$i++){
            $type=(new Type())->setType($typesTitle[$i])
                              ->setDescription($faker->paragraph());
            $types[]=$type;
            $manager->persist($type);
            $manager->flush();
        }

        $artistes=[];
        for($i = 0; $i <50; $i++){
            $typeArtiste = $types[rand(0,count($types)-1)];
            $genreChanson = $typeArtiste->getType();
            $dateA = DateTimeImmutable::createFromMutable($faker->dateTime());
            $song = (new Chanson())->setTitre($faker->text(50))
                                   ->setDateSortie($dateA)
                                   ->setGenre($genreChanson)
                                   ->setLangue($faker->languageCode())
                                   ->setPhotoCouverture("https://picsum.photos/360/360?image=".$i);
                                   
            $dateNaissance = DateTimeImmutable::createFromMutable($faker->dateTime());
            $artiste = (new Artiste())->setNom($faker->lastName())
                                ->setPrenom($faker->firstName())
                                ->setDateNaissance($dateNaissance)
                                ->setLieuNaissance($faker->city())
                                ->setPhoto("https://picsum.photos/360/360?image=".$i)
                                ->setDescription($faker->paragraph())
                                ->setType($typeArtiste)
                                ->addParticiperChanson($song);
            $artistes[]=$artiste;
            $typeArtiste->addGenreArtiste($artiste);
            $song->addArtiste($artiste);
            $manager->persist($song);
            $manager->persist($artiste);
            $manager->flush();
        }

        $manager->flush();
    }
}
