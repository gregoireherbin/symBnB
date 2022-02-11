<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
          $faker= Factory::create('FR-fr');

            //Nous gérons les utilisateurs

            $users = [];
            $genres = ['male','female'];
          
            for ($i=1;$i<=9;$i++){

            $user = new User();
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId= $faker->numberBetween(0,99).'jpg';

            $picture.= ( $genre == 'male' ? 'men/' : 'women/') .$pictureId;

            $user->setFirstName($faker->firstname)
                 ->setLastName($faker->lastname)
                 ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>'.join('<p></p>', $faker -> paragraphs(3)).'</p>')   
                ->setHash('password')
                ->setPicture($picture);

                $manager->persist($user);
                $users[]=$user;
            }
          
          
          
          
            //Nous gérons les annonces

            for ($i=1;$i<=30;$i++){
               
            $ad = new Ad();

            $faker -> addProvider ( new \ Xvladqt \ Faker \ LoremFlickrProvider ( $faker ));

            $title = $faker ->sentence();
            $content = '<p>'.join('<p></p>', $faker -> paragraphs(5)).'</p>';
            $introduction = $faker -> paragraph (2);
            $coverImage = $faker -> imageUrl($width=1000,$height=350,['house']);
            $user= $users[mt_rand(0,count($users)-1)];
               
            $ad->setTitle($title)
                ->setContent($content)
                ->setIntroduction($introduction)
                ->setPrice(mt_rand(20,300))
                ->setRooms(mt_rand(1,5))
                ->setCoverImage($coverImage)
                ->setAuthor($user);
            
                
                        
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
