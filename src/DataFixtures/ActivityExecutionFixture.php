<?php

namespace App\DataFixtures;

//use Doctrine\Persistence\ObjectManager;

use App\Entity\Activity;
use App\Entity\ActivityExecution;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\DateTime;

class ActivityExecutionFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i=0; $i<7; $i++ ){
            $ActivityExecution = new ActivityExecution();
            $ActivityExecution->setDate($faker->dateTimeThisYear('now'));
            $freePlace=$faker->numberBetween(0,5);
            $ActivityExecution->setFreePlace($freePlace);
            $ActivityExecution->setIsComplete(((5-$freePlace) == 0) ? true : false);
           // $ActivityExecution->setActivity()
            // $manager->persist($ActivityExecution);
        }

        // $manager->flush();
    }
}
