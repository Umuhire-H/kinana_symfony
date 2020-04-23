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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoderInterface)
    {
        $this->passwordEncoder = $passwordEncoderInterface;
    }
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
        //$ActivityExecution->setDate($faker->dateTimeThisYear('now'));
        $ActivityExecution->setDate($faker->dateTimeBetween('now', '+30 days'));  
        $freePlace=$faker->numberBetween(0,5);
        $ActivityExecution->setFreePlace($freePlace);
        $ActivityExecution->setIsComplete(((5-$freePlace) == 0) ? true : false);
        $ActivityExecution->setActivity($activity);
        //$manager->persist($ActivityExecution);
        //------------
        //-- ACTIVITY
        $activity2 = new Activity();
        $activity2->setName("jardinage");
        $activity2->setDescription($faker->realText(500, 2));
        $activity2->setPlace(5);
        $activity2->setPrice(30.00);
        $manager->persist($activity2);
        
        //--ACTIVITY-EXECUTION
        $ActivityExecution2 = new ActivityExecution();
        $ActivityExecution2->setDate($faker->dateTimeBetween('-2 days', '+30 days'));
        //$ActivityExecution2->setDate($faker->dateTimeThisYear('now')); 
        $freePlace=$faker->numberBetween(0,5);
        $ActivityExecution2->setFreePlace($freePlace);
        $ActivityExecution2->setIsComplete(((5-$freePlace) == 0) ? true : false);
        $ActivityExecution2->setActivity($activity2);
        //$manager->persist($ActivityExecution2);
        //-----------------------------
       
        $array_executions = array();
        array_push( $array_executions, $ActivityExecution2 );
        array_push( $array_executions, $ActivityExecution );

        $array_parents = array();
        for ($i=0; $i<4; $i++ ){
            //-PARENT-
            $parent = new User();
            $parent->setEmail($faker->freeEmail);
            $parent->setRoles(['ROLE_USER','ROLE_PARENT']);
            $parent->setPassword($this->passwordEncoder->encodePassword($parent,'test1234='));
            $parent->setFirstName($faker->firstName);
            $parent->setLastName($faker->lastName);
            $parent->setDateBirth($faker->dateTimeBetween('-50 years','-20 years'))
            ;
            array_push( $array_parents, $parent );
        }
            foreach( $array_parents as $parent ){
                $manager->persist($parent);
                $children = array();
                 for ($i=0; $i<2; $i++ ){
                     //-- Child
                     $child = new Child();
                     $child->setFirstName($faker->firstName);
                     $child->setLastName($faker->lastName);
                     $child->setDateBirth($faker->dateTimeBetween('-5 years','-2 years'));
                     $child->addUserParent($parent);
                     //  $child->addParticipation: done
                     array_push($children, $child);
                    
                     //-- Participation
                     foreach( $array_executions as $OneExcecution ){
                        $manager->persist($OneExcecution);

                         $participation=new Participation();
                         //--                        
                         $dateExecution=  $OneExcecution->getDate();
                         //--
                         $participation->setActivityExecution($OneExcecution);
                         $participation->setPricePayed($OneExcecution->getActivity()->getPrice());
                         if( $dateExecution< new DateTime('now') ){
                             $participation->setDatePayement($dateExecution);
                             $participation->setTypePayement('cash'); 
                             $participation->setStatusPayement('paid');
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
            }
            //--------------activity2 - activityExe2-parent 2--
            
            
        
        //-- ANIMATEUR
        foreach( $array_executions as $OneExcecution ){
            $animator = new User();
            $animator->setEmail($faker->freeEmail);
            $animator->setRoles(['ROLE_USER','ROLE_USER_ANIMATOR']);
            $animator->setPassword($this->passwordEncoder->encodePassword($animator,'test1234='));
            $animator->setFirstName($faker->firstName);
            $animator->setLastName($faker->lastName);
            $animator->setDateBirth($faker->dateTimeBetween('-70 years','-40 years'));
            $animator->addActivityExecution($OneExcecution);
            $manager->persist($animator);
        }
       //-- TRADUCTEUR
        $traductor = new User();
        $traductor->setEmail($faker->freeEmail);
        $traductor->setRoles(['ROLE_USER','ROLE_USER_TRADUCTOR']);
        $traductor->setPassword($this->passwordEncoder->encodePassword($traductor,'test1234='));
        $traductor->setFirstName($faker->firstName);
        $traductor->setLastName($faker->lastName);
        $traductor->setDateBirth($faker->dateTimeBetween('-70 years','-40 years'));
        //$manager->persist($traductor);
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
        //$manager->persist($traductor);

        //--
        $traductor->addTranslatedText($text);        
        
        //-------------------------------------------------------------------------
        $manager->flush();
    }
}
