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
use AppBundle\Entity\User;
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
            $this->addReference('attendant'.$i, $attendant);
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
            $this->addReference('fasubspecie'.$i, $subspecie_fauna);
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
            $flora->setPlantationDate("January 2005");
            $flora->setName('plantita '.$i);
            $flora->setArea($this->getReference('area'.rand(0, 19)));
            $flora->setSubspecie($this->getReference('flsubspecie'.rand(0,9)));
            $manager->persist($flora);
        }

        //crea 50 individuos de fauna
        for ($i = 0; $i < 50; $i++) {
            $fauna=new Fauna();
            $fauna->setName('animalito '.$i);
            $fauna->setWeight(rand(3,150));
            $fauna->setHealthObservations($this->generateRandomString(30));
            $fauna->setAttendants(array($this->getReference('attendant'.rand(0,19))));
            $fauna->setDestination($this->generateRandomString(10));
            $fauna->setSubspecie($this->getReference('fasubspecie'.rand(0,9)));
            $manager->persist($fauna);
        }

        //crea un usuario administrador, con nombre de usuario admin y contraseña admin
        $userAdmin = new User();
        $userAdmin->addRole("ROLE_ADMIN");
        $userAdmin->setUsername("admin");
        $userAdmin->setUsernameCanonical("admin");
        $userAdmin->setEmail("admin@admin.com");
        $userAdmin->setEmailCanonical("admin@admin.com");
        $userAdmin->setPlainPassword('admin');
        $userAdmin->setEnabled(true);
        $manager->persist($userAdmin);

        //crea un usuario responsable de informes, con nombre de usuario resp y contraseña resp
        $userResp = new User();
        $userResp->addRole("ROLE_REPORTS");
        $userResp->setUsername("resp");
        $userResp->setUsernameCanonical("resp");
        $userResp->setEmail("resp@resp.com");
        $userResp->setEmailCanonical("resp@resp.com");
        $userResp->setPlainPassword('resp');
        $userResp->setEnabled(true);
        $manager->persist($userResp);

        //crea un usuario data entry, con nombre de usuario data y contraseña data
        $userData = new User();
        $userData->addRole("ROLE_DATA_ENTRY");
        $userData->setUsername("data");
        $userData->setUsernameCanonical("data");
        $userData->setEmail("data@data.com");
        $userData->setEmailCanonical("data@data.com");
        $userData->setPlainPassword('data');
        $userData->setEnabled(true);
        $manager->persist($userData);

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
