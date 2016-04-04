<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Comentario;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class ComentarioController extends Controller {

    public function comentarioAction(Request $request,$id)
    {
        $repositoryProducto = $this ->getDoctrine()->getRepository("AppBundle:Producto");
        $repositoryUser = $this ->getDoctrine()->getRepository("AppBundle:User");

        $em = $this->getDoctrine()->getManager();

        $idProducto = $repositoryProducto->find($id);
        $usuarioId = $this->getUser();

        if($usuarioId == NULL )
        {
            $usuario = $repositoryUser->find($usuarioId = 17);
        }
        else
        {
            $usuario = $repositoryUser->find($usuarioId);
        }

        $comentario = new Comentario();

        $comentario->setProducto($idProducto);
        $comentario->setUser($usuario);

        $form = $this->createFormBuilder($comentario)
            ->add('titulo','text', array(
                    'attr'=>array(
                        'class'=>'form-control input-lg',
                    ))
            )
            ->add('contenido', 'textarea', array(
                    'attr'=>array(
                        'class'=>'form-control',
                        'placeholder' => '140 caracteres máximo'
                    ))
            )
            ->add('nombre','text',array(
                'required'=> false,
                'attr'  => array(
                    'placeholder' => '(no es obligatorio)',
                    'class'=>'form-control',
                ),
            ))
            ->getForm();

        if ($request->server->get('REQUEST_METHOD') == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {

                $em->persist($comentario);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Comentario añadido correctamente');
                return $this->redirect($this->generateUrl('appBundle_producto',array('id' => $id)));
            }
        }

        $params['producto'] = $idProducto;
        $params['titulo'] = '';
        $params['contenido'] = '';
        $params['nombre'] = '';
        $params['user'] = $usuario;
        $params['form'] = $form->createView();

        return $this->render(
            'AppBundle:Default:comentario.html.twig',
            $params);

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
            'AppBundle:Default:adminListaComentario.html.twig',$params);
    }

    public function eliminarAction(Request $request,$id)
    {
        $repositoryComentario = $this ->getDoctrine()->getRepository("AppBundle:Comentario");

        $em = $this->getDoctrine()->getManager();
        $comentario = $repositoryComentario->find($id);

        $em->remove($comentario);
        $em->flush();

        $this->get('session')->getFlashBag()->add('error', ' Comentario <strong>'.$comentario->getTitulo().'</strong> eliminado correctamente');

        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $tiendas = $userLogin->getTiendas();

        $params = array('tiendas' => $tiendas,
            'producto'=> $comentario);

        return $this->render('AppBundle:Default:adminListaComentario.html.twig',$params);
    }

} 