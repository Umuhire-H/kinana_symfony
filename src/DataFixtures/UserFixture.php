<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
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
        
        $member = new User();
        $member->setEmail($faker->freeEmail);
        $member->setRoles(['ROLE_USER']);
        $member->setPassword($this->passwordEncoder->encodePassword($member,'test1234='));
        $member->setFirstName($faker->firstName);
        $member->setLastName($faker->lastName);
        $member->setDateBirth($faker->dateTimeBetween('-50 years','-20 years'));
        $manager->persist($member);

        $manager->flush();
    }
}
