<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
          $faker= Factory::create('FR-fr');
        
            for ($i=1;$i<=30;$i++){
               
            $ad = new Ad();

            $faker -> addProvider ( new \ Xvladqt \ Faker \ LoremFlickrProvider ( $faker ));

            $title = $faker ->sentence();
            $content = '<p>'.join('<p></p>', $faker -> paragraphs(5)).'</p>';
            $introduction = $faker -> paragraph (2);
            $coverImage = $faker -> imageUrl($width=1000,$height=350,['house']);
               
            $ad->setTitle($title)
                ->setContent($content)
                ->setIntroduction($introduction)
                ->setPrice(mt_rand(20,300))
                ->setRooms(mt_rand(1,5))
                ->setCoverImage($coverImage);
            
                
                        
                for ($j=1;$j<=mt_rand(2,5);$j++){

                    $image = new Image();

                    $image->setUrl($faker->imageUrl($width=1000,$height=350,['house']))
                        ->setAd($ad) 
                        ->setCaption($faker->sentence());  
                    
                    $manager->persist($image);
                        }

                        $manager->persist($ad); 
                    
                    }


                $manager->flush();
     }

            
}
