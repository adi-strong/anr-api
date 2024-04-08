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
      ->setEmail('adi.life91@gmail.com')
      ->setPhone('+243 891 759 667')
      ->setFullName('rook')
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

    $provinces = ['Kinshasa', 'Kongo-central', 'Haut-Katanga'];
    foreach ($provinces as $str) {
      $province = (new Province())->setName($str);
      $manager->persist($province);

      for ($a=0; $a < mt_rand(1, 5); $a++) {
        $agent = (new Agent())
          ->setName($faker->name)
          ->setLastName($faker->lastName)
          ->setFirstName($faker->firstName)
          ->setSex($faker->randomElement(['H', 'F']))
          ->setPhone($faker->phoneNumber)
          ->setState('active')
          ->setProvince($province)
          ->setOrigin($faker->randomElement(['Équateur', 'Kasaï', 'Est']))
          ->setGodFather($faker->name)
          ->setRegister($faker->randomDigit())
          ->setBornAt($faker->dateTimeBetween('-60 years', '-30 years'))
          ->setLevelOfStudies($faker->randomElement(['D6', 'Gradué(e)', 'Licencié(e)', 'Doctorant']))
          ->setCartNumber($faker->randomDigit())
          ->setPseudo($faker->userName)
          ->setBlood($faker->randomElement(['O', 'A', 'OB', 'B']))
          ->setMaritalStatus('single')
          ->setBornPlace($faker->city)
          ->setEmail($faker->email)
          ->setGodFatherNum($faker->phoneNumber)
          ->setAddress($faker->address)
          ->setFather($faker->firstNameMale)
          ->setMother($faker->firstNameFemale);
        $manager->persist($agent);
      }
    }

    // ***********************************************************************************************

    $manager->flush();
  }
}
