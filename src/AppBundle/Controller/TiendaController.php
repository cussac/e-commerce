<?php
/**
 * Created by PhpStorm.
 * User: nacho
 * Date: 6/02/16
 * Time: 13:43
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use AppBundle\Entity\Tienda;
use AppBundle\Form\TiendaType;


class TiendaController extends Controller
{
    public function formularioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repositoryUser = $this ->getDoctrine()->getRepository("AppBundle:User");

        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());

        $tienda= new Tienda();

        $form = $this->createForm(new TiendaType(), $tienda);

        if ($this->getRequest()->isMethod('POST'))
        {

            $form->bind($request);
            if ($form->isValid())
            {
                $usuario = $repositoryUser->find($userLogin);

                $tienda->setUser($usuario);

                $em->persist($tienda);
                $em->flush();


                $this->get('session')->getFlashBag()->add(
                        'success',
                        ' Ya estás registrado como:<strong> '.$tienda->getNombre().'</strong>.'
                );

                return $this->redirect($this->generateUrl('appBundle_admin_homepage'));

            }
            else
            {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    'Error, revise los campos del formulario'
                );
                $this->redirect($this->generateUrl("appBundle_admin_tienda"));
            }

        }

        $tiendas = $userLogin->getTiendas();

        $params = array(
            'tiendas' => $tiendas,
            'form' => $form->createView()
        );

        return $this->render('AppBundle:Default:tienda.html.twig',$params);
    }

    public function formularioCambioAction(Request $request,$username,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $repositoryUser = $this ->getDoctrine()->getRepository("AppBundle:User");
        $repositoryTienda = $this ->getDoctrine()->getRepository("AppBundle:Tienda");

        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $user = $userLogin->getUsername();

        $params['id'] = $id;

        if($id != 0 )
        {
            if($username != $user)
            {
                return $this->render('@App/Comunes/404.html.twig',array(
                    'mensaje' => "ERROR DE USUARIO"
                ));
            }
            else
            {
                $tienda = $repositoryTienda->find($id);

                if(!$tienda)
                {
                    return $this->render('@App/Comunes/404.html.twig',array(
                        'mensaje' => "ERROR DE TIENDA"
                    ));
                }
            }
        }
        else
        {
            return $this->render('@App/Comunes/404.html.twig',array(
                'mensaje' => "No existe nigun usuario con id"
            ));

        }

        $form = $this->createForm(new TiendaType(), $tienda);

        if ($this->getRequest()->isMethod('POST'))
        {

            $form->bind($request);
            if ($form->isValid())
            {
                $usuario = $repositoryUser->find($userLogin);

                $tienda->setUser($usuario);

                $em->persist($tienda);
                $em->flush();


                $this->get('session')->getFlashBag()->add(
                        'success',
                        ' <strong> '.$tienda->getNombre().'</strong> cambios realizados.'
                );

                return $this->redirect($this->generateUrl('appBundle_admin_tienda_perfil'));

            }
            else
            {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    'Error, revise los campos del formulario'
                );
                $this->redirect($this->generateUrl("appBundle_admin_tienda"));
            }

        }

        $tiendas = $userLogin->getTiendas();

        $params = array(
            'tiendas' => $tiendas,
            'form' => $form->createView()
        );

        return $this->render('AppBundle:Default:tienda.html.twig',$params);
    }

    public function perfilAction(Request $request)
    {
        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());

        $tiendas = $userLogin->getTiendas();

        $params = array('tiendas' => $tiendas);

        return $this->render(
            'AppBundle:Default:adminPerfilTienda.html.twig',$params);
    }

    public function eliminarAction(Request $request,$id)
    {
        $repositoryTienda = $this ->getDoctrine()->getRepository("AppBundle:Tienda");

        $em = $this->getDoctrine()->getManager();
        $tienda = $repositoryTienda->find($id);

        $em->remove($tienda);
        $em->flush();

        $this->get('session')->getFlashBag()->add('error', ' Tienda <strong>'.$tienda->getNombre().'</strong> eliminada correctamente');

        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $tiendas = $userLogin->getTiendas();

        $params = array('tiendas' => $tiendas,
            'tienda'=> $tienda);

        return $this->render('AppBundle:Default:adminIndex.html.twig',$params);
    }

} 