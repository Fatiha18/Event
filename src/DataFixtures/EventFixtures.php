<?php 

namespace App\DataFixtures;

use App\Entity\Events;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EventFixtures extends BaseFixtures implements DependentFixtureInterface
{
    protected function loadData()
    {
         $this->createMany(20, 'events', function (){
             return (new Events())
             ->setNom($this->faker->catchPhrase)
             ->setDescription($this->faker->text)
             ->setDate($this->faker->dateTimeBetween('-2 years'))
             ->setAuteur($this->getRandomRefence('auteur'))
             ->setLieu($this->faker->city)
            
             
             ;

         });
    }
    public function getDependencies()
    {
        return [

            UserFixtures::class,
        ];
    }
}