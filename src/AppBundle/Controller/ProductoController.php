<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use AppBundle\Entity\Tienda;
use AppBundle\Entity\Producto;
use AppBundle\Form\ProductoType;

class ProductoController extends Controller
{
    public function formularioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repositoryTienda = $this ->getDoctrine()->getRepository("AppBundle:Tienda");

        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());

        $producto = new Producto();

        $form = $this->createForm(new ProductoType(), $producto);

        if ($this->getRequest()->isMethod('POST'))
        {

            $form->bind($request);
            if ($form->isValid())
            {
                $tiendaId = $repositoryTienda->findOneByUser($userLogin);

                $producto->setTienda($tiendaId);

                $em->persist($producto);
                $em->flush();


                $this->get('session')->getFlashBag()->add(
                    'success',
                    ' Producto registrado como:<strong> '.$producto->getNombre().'</strong>.'
                );

                return $this->redirect($this->generateUrl('appBundle_admin_producto_lista'));

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

        return $this->render('AppBundle:Default:producto.html.twig',$params);
    }

    public function formularioCambioAction(Request $request,$username,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $repositoryTienda = $this ->getDoctrine()->getRepository("AppBundle:Tienda");
        $repositoryProducto = $this ->getDoctrine()->getRepository("AppBundle:Producto");

        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $user = $userLogin->getUsername();

        $params['id'] = $id;

        if($id != 0)
        {
            if($username != $user)
            {
                return $this->render('@App/Comunes/404.html.twig',array(
                    'mensaje' => "ERROR DE USUARIO"
                ));
            }
            else
            {
                $producto = $repositoryProducto ->find($id);

                if(!$producto )
                {
                    return $this->render('@App/Comunes/404.html.twig',array(
                        'mensaje' => "ERROR DE PRODUCTO"
                    ));
                }
            }
        }
        else
        {
            return $this->render('@App/Comunes/404.html.twig',array(
                'mensaje' => "No existe nigun producto con id"
            ));
        }

        $form = $this->createForm(new ProductoType(), $producto);

        if ($this->getRequest()->isMethod('POST'))
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $tiendaId = $repositoryTienda->findOneByUser($userLogin);

                $producto->setTienda($tiendaId);

                $em->persist($producto);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    ' <strong> '.$producto->getNombre().'</strong> cambios realizados.'
                );

                return $this->redirect($this->generateUrl('appBundle_admin_producto_lista'));
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

        return $this->render('AppBundle:Default:producto.html.twig',$params);
    }

    public function listaAction(Request $request)
    {

        $repositoryTienda = $this ->getDoctrine()->getRepository("AppBundle:Tienda");
        $repositoryUser = $this ->getDoctrine()->getRepository("AppBundle:User");

        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());

        $tiendas = $userLogin->getTiendas();

        $usuario = $this->getUser();
        $userId = $repositoryUser ->find($usuario);
        $tiendaId = $repositoryTienda->find($userId);

        $productos = $userLogin->getTiendas($tiendaId);

        $params = array('tiendas' => $tiendas,
                        'producto'=> $productos);

        return $this->render(
            'AppBundle:Default:adminListaProducto.html.twig',$params);
    }

    public function verAction($id)
    {
        $repositoryProducto = $this ->getDoctrine()->getRepository("AppBundle:Producto");
        $params['id'] = $id;

        $producto = $repositoryProducto->find($id);
        if(!$producto)
        {
            return $this->render('@App/Comunes/404.html.twig',array(
                'mensaje' => "No existe nigun producto con id".$producto->getId()
            ));
        }
        else
        {
            return $this->render(
                'AppBundle:Default:verProducto.html.twig',array('producto' => $producto));
        }
    }

    public function eliminarAction(Request $request,$id)
    {
        $repositoryProducto = $this ->getDoctrine()->getRepository("AppBundle:Producto");

        $em = $this->getDoctrine()->getManager();
        $producto = $repositoryProducto->find($id);
        $em->remove($producto);
        $em->flush();

        $this->get('session')->getFlashBag()->add('error', ' Producto <strong>'.$producto->getNombre().'</strong> eliminado correctamente');

        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $tiendas = $userLogin->getTiendas();

        $params = array('tiendas' => $tiendas,
                        'producto'=> $producto);

        return $this->render('AppBundle:Default:adminListaProducto.html.twig',$params);
    }

    public function listaAdminAction()
    {
        $userLogin = $this->getUser();
        $sesion = $this->getRequest()->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $em = $this->getDoctrine()->getManager();

        if(in_array("ROLE_SUPER_ADMIN",$userLogin->getRoles()))
        {
            $productos= $em->getRepository("AppBundle:Producto")->findAll();
        }
        else
        {
            $this->get('session')->getFlashBag()->add('error', 'No tienes permiso para acceder');
            return $this->redirect($this->generateUrl("appBundle_homepage"));
        }

        $params = array('productos' => $productos);

        return $this->render('AppBundle:Default:adminListaPoductos.html.twig',$params);
    }

}