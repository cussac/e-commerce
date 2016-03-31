<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;


class DqlController extends Controller
{
    public function buscarTNAction()
    {
        $params = array(
            'nombreT' => '',
            'resultado' => array()
        );

        $request = $this->getRequest();
        if ($request->server->get('REQUEST_METHOD') == 'POST')
        {
            $em = $this->getDoctrine()->getManager();
            $dql = "SELECT tie FROM AppBundle:Tienda tie where ";

            if ($request->request->get('nombreT') !== null
                && $request->request->get('nombreT') !== '')
            {
                $params['nombreT'] = $request->request->get('nombreT');
                $parametros_busqueda['nombreT'] = $request->request->get('nombreT');
                $dql .= "tie.nombre LIKE :param_nombreT" ;
            }

            if ($params['nombreT'] !== '')
            {
                $query = $em->createQuery($dql);
                $query->setParameter('param_nombreT','%'.$params['nombreT'].'%');
                $params['resultado'] = $query->getResult();
            }
        }

        return $this->render('AppBundle:Default:buscar.html.twig', $params);
    }

    public function buscarPNAction()
    {
        $params = array(
            'nombreP' => '',
            'resultado' => array()
        );

        $request = $this->getRequest();
        if ($request->server->get('REQUEST_METHOD') == 'POST')
        {
            $em = $this->getDoctrine()->getManager();
            $dql = "SELECT pro FROM AppBundle:Producto pro where ";

            if ($request->request->get('nombreP') !== null
                && $request->request->get('nombreP') !== '')
            {
                $params['nombreP'] = $request->request->get('nombreP');
                $parametros_busqueda['nombreP'] = $request->request->get('nombreP');
                $dql .= "pro.nombre LIKE :param_nombreP" ;
            }

            if ($params['nombreP'] !== '')
            {
                $query = $em->createQuery($dql);
                $query->setParameter('param_nombreP','%'.$params['nombreP'].'%');
                $params['resultado'] = $query->getResult();
            }
        }

        return $this->render('AppBundle:Default:buscar2.html.twig', $params);
    }

}