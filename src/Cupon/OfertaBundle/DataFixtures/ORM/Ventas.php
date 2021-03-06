<?php

namespace Cupon\OfertaBundle\DataFixtures\ORM;

#use Cupon\OfertaBundle\Entity\Oferta;
use Cupon\OfertaBundle\Entity\Venta;
#use Cupon\UsuarioBundle\Entity\Usuario;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Ventas extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 50;
    }
    public function load(ObjectManager $manager)
    {
        // Obtener todas las ofertas y usuarios de la base de datos
        $ofertas = $manager->getRepository('OfertaBundle:Oferta')->findAll();
        $usuarios = $manager->getRepository('UsuarioBundle:Usuario')->findAll();
        foreach ($usuarios as $usuario) {
            $compras = mt_rand(0, 3);
            $comprado = array();
            for ($i = 0; $i < $compras; ++$i) {
                $venta = new Venta();
                
                $venta->setFecha(new \DateTime('now - '.mt_rand(0, 250).' hours'));
                // Sólo se añade una venta:
                //   - si este mismo usuario no ha comprado antes la misma oferta
                //   - si la oferta seleccionada ha sido revisada
                //   - si la fecha de publicación de la oferta es posterior a ahora mismo
                $oferta = $ofertas[array_rand($ofertas)];
                while (in_array($oferta->getId(), $comprado)
                       || $oferta->getRevisada() === false
                       || $oferta->getFechaPublicacion() > new \DateTime('now')) {
                    $oferta = $ofertas[array_rand($ofertas)];
                }
                $comprado[] = $oferta->getId();
                $venta->setOferta($oferta);
                $venta->setUsuario($usuario);
                $manager->persist($venta);
                $oferta->setCompras($oferta->getCompras() + 1);
                $manager->persist($oferta);
            }
            unset($comprado);
        }
        $manager->flush();
    }
}