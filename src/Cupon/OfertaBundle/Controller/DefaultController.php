<?php

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; 


class DefaultController extends Controller
{
   // public function ayudaAction()
   // {
   //     return $this->render('OfertaBundle:Default:ayuda.html.twig');
   // }
    
    public function portadaAction($ciudad){
        
        
        if(null == $ciudad){
            $ciudad = $this->container
                           ->getParameter('cupon.ciudad_por_defecto');
            return new RedirectResponse($this->generateUrl('portada',array('ciudad'=>$ciudad)));
        }
        
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findBy(array(
            'ciudad' => $ciudad,
            'fecha_publicacion' => new \DateTime('today')            
        ));
        
        if(!$oferta){
            throw $this->createNotFoundException('No se ha encontrado oferta del dia para esta ciudad');
        }
        
        
        return $this->render('OfertaBundle:Default:portada.html.twig',array('oferta'=>$oferta[0]));
        
    }
}
