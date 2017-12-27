<?php

namespace Cupon\CiudadBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cupon\CiudadBundle\Entity\Ciudad;

Class Ciudades extends AbstractFixture implements FixtureInterface{
    
    public function getOrder(){
        return 1;
    }
    
    public function load(ObjectManager $manager){
        
        $ciudades = array(
          array('nombre'=>'Madrid'),
          array('nombre'=>'Barcelona'),
          array('nombre'=>'Santa Fe'),    
        );
      
        foreach($ciudades as $ciudad){
            $entidad = new Ciudad();            
            $entidad->setNombre($ciudad['nombre']);
            $manager->persist($entidad);
        }
        
        $manager->flush();
    }
    
} 