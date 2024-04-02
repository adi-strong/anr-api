<?php

namespace App\DataFixtures;

use App\Entity\Agent;
use App\Entity\Currency;
use App\Entity\Department;
use App\Entity\DepartmentService;
use App\Entity\Grade;
use App\Entity\Job;
use App\Entity\Province;
use App\Entity\User;
use Cocur\Slugify\Slugify;
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

    // Root Admin
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
    // End Root Admin

    $first = [
      "code" => "CDF",
      "flag" => "https://flagcdn.com/cd.svg",
      "image" => "https://flagcdn.com/cd.svg",
      "label" => "DR Congo (CDF)",
      "value" => "DR Congo (CDF)",
      "symbol" => "FC"
    ];

    $last = [
      "code" => "USD",
      "flag" => "https://flagcdn.com/us.svg",
      "image" =>  "https://flagcdn.com/us.svg",
      "label" =>  "United States (USD)",
      "value" =>  "United States (USD)",
      "symbol" =>  "$"
    ];
    $currency = (new Currency())
      ->setFirst($first)
      ->setLast($last)
      ->setRate(2800);
    $manager->persist($currency);
    // End Currency

    /*for ($d=0; $d < 10; $d++) {
      $department = (new Department())->setName($faker->text(30));
      $department->setSlug((new Slugify())->slugify($department->getName()));
      $manager->persist($department);
    }

    for ($p=0; $p < 20; $p++) {
      $provinceName = $faker->city;
      $provinceSlug = (new Slugify())->slugify($provinceName);
      $province = (new Province())
        ->setName($provinceName)
        ->setSlug($provinceSlug);
      $manager->persist($province);
    }*/

    // ***********************************************************************************************

    $manager->flush();
  }
}
