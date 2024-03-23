<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
  public function __construct(private readonly UserPasswordHasherInterface $encoder) { }

  public function load(ObjectManager $manager): void
  {
    $faker = Factory::create('EN_en');

    $root = (new User())
      ->setPassword('root')
      ->setRoles(['ROLE_SUPER_ADMIN'])
      ->setUsername('root')
      ->setEmail($faker->email)
      ->setPhone($faker->phoneNumber)
      ->setFullName($faker->name)
      ->setCreatedAt(new \DateTime());

    $rootPassword = $this->encoder->hashPassword($root, $root->getPassword());
    $root->setPassword($rootPassword);
    $manager->persist($root);

    // ***********************************************************************************************

    $manager->flush();
  }
}
