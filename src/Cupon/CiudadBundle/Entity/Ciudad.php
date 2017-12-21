<?php

namespace Cupon\CiudadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
  * @ORM\Entity
  * @ORM\Table(name="ProyectoCupon_Ciudad")
  */

class Ciudad {
    /** @ORM\Column(type="integer") */
    protected $id;
    
    /** @ORM\Column(type="string", length=100) */
    protected $nombre;
    
    /** @ORM\Column(type="string", length=100) */
    protected $slug;       
}
