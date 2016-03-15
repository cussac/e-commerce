<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\Tienda;



class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    public function indexAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $params['id'] = $id;

        if ($id === -1)
            return $this->render('AppBundle:Default:index.html.twig');
        else
        {
            $tiendas = $em->getRepository('AppBundle:Tienda')
                ->find($id);
            if(!$tiendas)
            {
                throw $this->createNotFoundException(
                    'No existe nigun usuario con id '.$id);
            }
            else
            {

                return $this->render(
                    'AppBundle:Default:indexId.html.twig',array('tiendas' => $tiendas));
            }
        }
    }

    public function adminIndexAction(Request $request)
    {
        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());

        $tiendas = $userLogin->getTiendas();

        $params = array('tiendas' => $tiendas);

        return $this->render(
            'AppBundle:Default:adminIndex.html.twig',$params);
    }
}
