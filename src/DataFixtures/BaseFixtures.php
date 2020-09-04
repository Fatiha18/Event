<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Classe "modéle"
 * 
 */

abstract class BaseFixtures extends Fixture
{
    /** @var ObejectManager */
  private $manager;
   /** @var Generator */
  protected $faker;
 

/**
 * Méthode à implémenter par la classes qui hérite
 * pour générer les fausses données
 */

   abstract protected function loadData();

   /**
    * Méthode appelée par le systeme fixture
    */

    public function load(ObjectManager $manager)
    {
        // on enregistre le objetcManager
        $this->manager = $manager;
        // on instancie Faker
        $this->faker = Factory::create('fr_FR');

       //On appelle laodData() pour avoir les fausses données
       $this->loadData();
       // On exécute l'enregistrement en base
       $this->manager->flush();
    }
    /**
     * Enregistrer plusieurs entités 
     * @param int $count   nomre entity à générer
     * @param callable $factory fonction qui génére 1 entité
     */

     protected function createMany(int $count, string $groupName, callable $factory)
    {
         for($i = 0; $i < $count; $i++){
             // On exécute $factory qui doit retourner l'entité générée
             $entity = $factory($i);

             // vérifier que l'entité ait été retournée
             if ($entity === null){

                 throw new \logicException('l\'entité doit être retournée. Auriez-vous oublié un "return" ?');
            }
             //On prépare à l'enresgistrement de l'entité
             $this->manager->persist($entity);
             
               // Enregistre une référence à l'entité
               $reference = sprintf('%s_%d', $groupName, $i);
               $this->addReference($reference, $entity);

             
        } 
    } 


     /**
      * Récupérer 1 entité par son nom de groupe de référence
      */

      protected function getRandomRefence(string $groupName)
      {
        // vérifier si on a déja enregistré les références du groupe demandé 
        if(!isset($this->references[$groupName])){

            //si,non on va rechercher les références

             $this->references[$groupName] = [];



             // on parcourt la liste de toutes les réferences

             foreach ($this->referenceRepository->getReferences() as $key => $ref){
                 //
                 //
                 if(strpos($key, $groupName) === 0){
                     $this->references[$groupName][] = $key;
                 }
             }

        }

        if ($this->references[$groupName] === []){
            throw new \Exception(sprintf('Aucune référence trouvée pour le groupe "%s"', $groupName));
        }
        // Retourner une entité 
        $randomReference = $this->faker->randomElement($this->references[$groupName]);
        return $this->getReference($randomReference);
      }
}