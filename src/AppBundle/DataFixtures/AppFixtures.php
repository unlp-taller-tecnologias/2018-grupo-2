<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Area;
use AppBundle\Entity\Attendant;
use AppBundle\Entity\Category;
use AppBundle\Entity\FASpecie;
use AppBundle\Entity\FASubspecie;
use AppBundle\Entity\Fauna;
use AppBundle\Entity\Flora;
use AppBundle\Entity\FLSpecie;
use AppBundle\Entity\FLSubspecie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // crea 20 areas
        for ($i = 0; $i < 20; $i++) {
            $area=new Area();
            $area->setName('Area '.$i);
            $area->setPolygon(mt_rand(10, 100));
            $manager->persist($area);
            $this->addReference('area'.$i, $area);
        }

        //crea 10 categorias
        for ($i = 0; $i < 10; $i++) {
            $category=new Category();
            $category->setName('Categoria '.$i);
            $manager->persist($category);
            $this->addReference('category'.$i, $category);
        }

        //crea 20 encargados sin linkear con sus categorias
        for ($i = 0; $i < 20; $i++) {
            $attendant=new Attendant();
            $attendant->setEmail($this->generateRandomString(10).'@gmail.com');
            $attendant->setName($this->generateRandomString(8));
            $attendant->setLastName($this->generateRandomString(8));
            $attendant->setCategory($this->getReference('category'.rand(0, 9)));
            $manager->persist($attendant);
        }

        //crea 20 especies de fauna
        for ($i = 0; $i < 20; $i++) {
            $specie_fauna=new FASpecie();
            $specie_fauna->setName('EspecieFauna '.$i);
            $manager->persist($specie_fauna);
            $this->addReference('faspecie'.$i, $specie_fauna);
        }

        //crea 10 subspecies de fauna
        for ($i = 0; $i < 10; $i++) {
            $subspecie_fauna=new FASubspecie();
            $subspecie_fauna->setName('SubespecieFauna '.$i);
            $subspecie_fauna->setSpecie($this->getReference('faspecie'.rand(0,19)));
            $manager->persist($subspecie_fauna);
        }

        //crea 20 especies de flora
        for ($i = 0; $i < 20; $i++) {
            $specie_flora=new FLSpecie();
            $specie_flora->setName('EspecieFlora '.$i);
            $manager->persist($specie_flora);
            $this->addReference('flspecie'.$i, $specie_flora);
        }

        //crea 10 subspecies de flora
        for ($i = 0; $i < 10; $i++) {
            $subspecie_flora=new FLSubspecie();
            $subspecie_flora->setName('SubespecieFlora '.$i);
            $subspecie_flora->setSpecie($this->getReference('flspecie'.rand(0,19)));
            $manager->persist($subspecie_flora);
            $this->addReference('flsubspecie'.$i, $subspecie_flora);
        }

        //crea 50 individuos de flora
        for ($i = 0; $i < 50; $i++) {
            $flora=new Flora();
            $flora->setObservations($this->generateRandomString(15));
            #CAMBIAR ESTO DE EDAD AL ALTERAR LA BD
            $flora->setAge(rand(0,100));
            $flora->setName('plantita '.$i);
            $flora->setArea($this->getReference('area'.rand(0, 19)));
            $flora->setSubspecie($this->getReference('flsubspecie'.rand(0,9)));
            $manager->persist($flora);
        }





        $manager->flush();
    }
    function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
}
