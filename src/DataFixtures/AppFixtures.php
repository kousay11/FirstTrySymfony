<?php

namespace App\DataFixtures;

use Faker\Generator;
use Faker\Factory;
use App\Entity\Ingridient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
   /**
    * @var Generator
    */
    private Generator $faker;

    public function __construct()
    {
        $this->faker=Factory::create('fr_FR');
    }



    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i < 50 ; $i++) { 
            $ingredient= new Ingridient();
            $ingredient->setName($this->faker->word())
                ->setPrice(3.0);
        $manager->persist($ingredient);
        }
        
        $manager->flush();
    }
}
