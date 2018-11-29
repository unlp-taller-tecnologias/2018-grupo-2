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
        }

        //crea 10 categorias
        for ($i = 0; $i < 10; $i++) {
            $category=new Category();
            $category->setName('Categoria '.$i);
            $manager->persist($category);
        }

        //crea 20 encargados sin linkear con sus categorias
        for ($i = 0; $i < 20; $i++) {
            $attendant=new Attendant();
            $attendant->setEmail($this->generateRandomString(10).'@gmail.com');
            $attendant->setName($this->generateRandomString(8));
            $attendant->setLastName($this->generateRandomString(8));
            $manager->persist($attendant);
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
