<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Text;
use App\Entity\User;
use App\Entity\Child;
use App\Entity\Activity;
use App\Entity\Participation;
use App\Entity\ActivityExecution;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Provider\Lorem;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $faker->seed(1234);

        
            
        //-- ACTIVITY
        $activity = new Activity();
        $activity->setName("bricolage");
        $activity->setDescription($faker->realText(500, 2));
        $activity->setPlace(5);
        $activity->setPrice(30.00);
        $manager->persist($activity);
        
        //--ACTIVITY-EXECUTION
        $ActivityExecution = new ActivityExecution();
        $ActivityExecution->setDate($faker->dateTimeThisYear('now'));
        $freePlace=$faker->numberBetween(0,5);
        $ActivityExecution->setFreePlace($freePlace);
        $ActivityExecution->setIsComplete(((5-$freePlace) == 0) ? true : false);
        $ActivityExecution->setActivity($activity);
        // $manager->persist($ActivityExecution);
        
        for ($i=1; $i<3; $i++ ){
            //-PARENT-
            $parent = new User();
            $parent->setEmail($faker->freeEmail);
            $parent->setRoles(['ROLE_USER','ROLE_PARENT']);
            $parent->setPassword('test1234=');
            $parent->setFirstName($faker->firstName);
            $parent->setLastName($faker->lastName);
            $parent->setDateBirth($faker->dateTimeBetween('-50 years','-20 years'))
            ;
            $manager->persist($parent);
            for ($i=0; $i<2; $i++ ){
                //-- Child
                $child = new Child();
                $child->setFirstName($faker->firstName);
                $child->setLastName($faker->lastName);
                $child->setDateBirth($faker->dateTimeBetween('-5 years','-2 years'));
                $child->addUserParent($parent);
                //  $child->addParticipation: done
    
                //-- Participation
                $participation=new Participation();
                //--
                $OneExcecution = $ActivityExecution;
                $dateExecution=  $OneExcecution->getDate();
                //--
                $participation->setActivityExecution($OneExcecution);
                $participation->setPricePayed($OneExcecution->getActivity()->getPrice());
                if( $dateExecution< new DateTime('now') ){
                    $participation->setDatePayement($dateExecution);
                    $participation->setTypePayement('cash'); 
                    $participation->setStatusPayement('payed');
                }
                if( $dateExecution> new DateTime('now') ){
                    $participation->setDatePayement($faker->dateTimeBetween('now','+10 days'));
                    $participation->setTypePayement('paypal'); 
                    $participation->setStatusPayement('in process');
                }               
                $participation->setComment($faker->realText(100, 2));
                //$participation->setUser(); : no need
                
                $manager->persist($participation);
                $child->addParticipation($participation);
                $manager->persist($child);
                $participation->setChild($child);
            }
            
        }
        //-- ANIMATEUR
        $animator = new User();
        $animator->setEmail($faker->freeEmail);
        $animator->setRoles(['ROLE_USER','ROLE_USER_ANIMATOR']);
        $animator->setPassword('test1234=');
        $animator->setFirstName($faker->firstName);
        $animator->setLastName($faker->lastName);
        $animator->setDateBirth($faker->dateTimeBetween('-70 years','-40 years'));
        $otherExcecution = $ActivityExecution;
        $animator->addActivityExecution($otherExcecution);
        $manager->persist($animator);
       //-- TRADUCTEUR
        $traductor = new User();
        $traductor->setEmail($faker->freeEmail);
        $traductor->setRoles(['ROLE_USER','ROLE_USER_TRADUCTOR']);
        $traductor->setPassword('test1234=');
        $traductor->setFirstName($faker->firstName);
        $traductor->setLastName($faker->lastName);
        $traductor->setDateBirth($faker->dateTimeBetween('-70 years','-40 years'));
        $manager->persist($traductor);
        //-- TEXT
        $text = new Text();
        $text->setName('Une comptine');
        $text->setContentToTranslate($faker->realText(300, 2));
        $text->setContentTranslated($faker->text(300, 2));
        $text->setDateReception($faker->dateTimeThisMonth('now'));
        $text->setDateReception($faker->dateTimeBetween('-30 days','-20 days'));
        $text->setDateReturn($faker->dateTimeBetween('-15 days','now'));
        $oneParent = $parent;
        $text->setUserRequester($oneParent);
        $text->setRating($faker->numberBetween(0,5));
        $text->setComment($faker->realText(100, 2));
        $manager->persist($traductor);

        //--
        $traductor->addTranslatedText($text);        
        
        //-------------------------------------------------------------------------
        //$manager->flush();
    }
}
