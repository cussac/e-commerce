<?php
/**
 * Created by PhpStorm.
 * User: nacho
 * Date: 14/01/16
 * Time: 18:47
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\PerfilType;
use AppBundle\Form\PassType;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;



class UserController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        // obtiene el error de inicio de sesión si lo hay
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('AppBundle:Default:login.html.twig', array(
            // el último nombre de usuario ingresado por el usuario
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    public function registroAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $usuario = new User();
        $form = $this->createForm(new UserType(), $usuario);

        if ($this->getRequest()->isMethod('POST'))
        {

            $form->bind($request);
            if ($form->isValid())
            {

                $usuario->setRol('ROLE_REGISTRADO');

                //PASSWORD ENCODER
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($usuario);
                // Evidentemente, nuestro password vendrá de un formulario
                $password = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
                $usuario->setPassword($password);

                $em->persist($usuario);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    ' Ya estás registrado como:<strong> '.$usuario->getUsername().'</strong>.'
                );

                return $this->redirect($this->generateUrl('appBundle_login'));

            }
            else
            {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    ' Error, revise los campos del formulario'
                );
                $this->redirect($this->generateUrl("appBundle_registro"));
            }

        }
        return $this->render('AppBundle:Default:registro.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function registroCambioAction(Request $request,$username,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $repositoryUser = $this ->getDoctrine()->getRepository("AppBundle:User");

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
                $usuario = $repositoryUser->find($id);
                $idUsuario = $userLogin->getId();

                if(!$usuario )
                {
                    return $this->render('@App/Comunes/404.html.twig',array(
                        'mensaje' => "ERROR DE USUARIO"
                    ));
                }
                elseif($idUsuario != $id)
                {
                    return $this->render('@App/Comunes/404.html.twig',array(
                        'mensaje' => "ERROR DE USUARIO"
                    ));
                }
            }

        }
        else
        {
            return $this->render('@App/Comunes/404.html.twig',array(
                'mensaje' => "ERROR DE USUARIO"
            ));
        }

        $form = $this->createForm(new PerfilType(), $usuario);

        if ($this->getRequest()->isMethod('POST'))
        {

            $form->bind($request);
            if ($form->isValid())
            {

                $usuario->setRol('ROLE_REGISTRADO');



                $em->persist($usuario);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    ' <strong> '.$usuario->getUsername().'</strong> datos modificados.'
                );

                return $this->redirect($this->generateUrl('appBundle_admin_user'));

            }
            else
            {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    ' Error, fallo al realizar cambios'
                );
                $this->redirect($this->generateUrl("appBundle_admin_user"));
            }


        }

        $tiendas = $userLogin->getTiendas();
        $params = array(
            'tiendas' => $tiendas,
            'form' => $form->createView()
        );

        return $this->render('AppBundle:Default:adminUserCambio.html.twig',$params
        );
    }

    public function passCambioAction(Request $request,$username,$id)
    {

        $em = $this->getDoctrine()->getManager();

        $repositoryUser = $this ->getDoctrine()->getRepository("AppBundle:User");

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
                $usuario = $repositoryUser->find($id);
                $idUsuario = $userLogin->getId();

                if(!$usuario )
                {
                    return $this->render('@App/Comunes/404.html.twig',array(
                        'mensaje' => "ERROR DE USUARIO"
                    ));
                }
                elseif($idUsuario != $id)
                {
                    return $this->render('@App/Comunes/404.html.twig',array(
                        'mensaje' => "ERROR DE USUARIO"
                    ));
                }
            }

        }
        else
        {
            return $this->render('@App/Comunes/404.html.twig',array(
                'mensaje' => "ERROR DE USUARIO"
            ));
        }

        $form = $this->createForm(new PassType(), $usuario);

        if ($this->getRequest()->isMethod('POST'))
        {

            $form->bind($request);
            if ($form->isValid())
            {

                $usuario->setRol('ROLE_REGISTRADO');

                //PASSWORD ENCODER
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($usuario);
                // Evidentemente, nuestro password vendrá de un formulario
                $password = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
                $usuario->setPassword($password);

                $em->persist($usuario);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    ' <strong> '.$usuario->getUsername().'</strong> datos modificados.'
                );

                return $this->redirect($this->generateUrl('appBundle_admin_user'));

            }
            else
            {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    ' Error, fallo al realizar cambios'
                );
                $this->redirect($this->generateUrl("appBundle_admin_user"));
            }
        }

        $tiendas = $userLogin->getTiendas();
        $params = array(
            'tiendas' => $tiendas,
            'form' => $form->createView()
        );

        return $this->render('AppBundle:Default:adminPassCambio.html.twig',$params);

    }

    public function perfilAction(Request $request)
    {
        $userLogin = $this->getUser();
        $sesion = $request->getSession();
        $sesion->set('usuario_id',$userLogin->getId());

        $tiendas = $userLogin->getTiendas();

        $params = array('tiendas' => $tiendas);

        return $this->render('AppBundle:Default:adminPerfil.html.twig',$params);
    }

    public function eliminarAction($id)
    {
        $repositoryUser = $this ->getDoctrine()->getRepository("AppBundle:User");

        $em = $this->getDoctrine()->getManager();
        $user = $repositoryUser->find($id);

        $em->remove($user);
        $em->flush();

        $this->get('session')->getFlashBag()->add('error', ' Ususario <strong>'.$user->getUsername().'</strong> eliminado correctamente');

        $params = array('user'=> $user);

        return $this->render('AppBundle:Default:adios.html.twig');
    }

} 