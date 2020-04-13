<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Activity;
use App\Entity\ActivityExecution;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i=1; $i<7; $i++ ){
            
            //-- Activity
            $activity = new Activity();
            $activity->setName("bricolage". $i);
            $activity->setDescription($faker->realText(500, 2));
            $activity->setPlace(5);
            $activity->setPrice(30.00);
            $manager->persist($activity);
            //--
            $ActivityExecution = new ActivityExecution();
            $ActivityExecution->setDate($faker->dateTimeThisYear('now'));
            $freePlace=$faker->numberBetween(0,5);
            $ActivityExecution->setFreePlace($freePlace);
            $ActivityExecution->setIsComplete(((5-$freePlace) == 0) ? true : false);
            $ActivityExecution->setActivity($activity);
            $manager->persist($ActivityExecution);
        }
     


        $manager->flush();
    }
}
