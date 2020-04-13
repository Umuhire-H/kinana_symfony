<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ActivityFixture extends Fixture
{
   // public const ACTIVITY_ACTIVITYEXEC_REFERENCE = 'activity-activityExecution';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i=0; $i<7; $i++ ){
            $activity  = new Activity();
            $activity->setName("bricolage". $i);
            $activity->setDescription($faker->realText(500, 2));
            $activity->setPlace(5);
            $activity->setPrice(30.00);
            //$manager->persist($activity);
        }
       

      //  $manager->flush();
      //  $this->addReference('ACTIVITY_'.$i, $activity);
    }
}
