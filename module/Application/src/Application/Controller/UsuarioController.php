<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Usuario;

class UsuarioController extends AbstractActionController
{
    public function indexAction()
    {
        return $this->redirect()->toUrl('/application/usuario/login');

        $table = $this->getServiceLocator()
            ->get('Application\Model\UsuarioTable');

        if ($table->verificar() === false) {
            return $this->redirect()->toUrl('/application/usuario/login');
        }

    	$usuarios = $table->findAll();

        return new ViewModel([
        	'clientes' => $usuarios
        ]);
    }

    public function loginAction()
    {
        $table = $this->getServiceLocator()
            ->get('Application\Model\UsuarioTable');

        if ($table->estaLogado() === true) {
            return $this->redirect()->toUrl('/application/categoria/index');
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $usuario = new Usuario();
            $usuario->exchangeArray($data);
            $table = $this->getServiceLocator()
            ->get('Application\Model\UsuarioTable');
            $retorno = $table->entrar($usuario);
            $strErro = '';

            if ($retorno) {
                return $this->redirect()->toUrl('/application/categoria/index');
            } else {
                 $strErro = 'Usuário ou senha inválidos.';
            }
        }

        return new ViewModel([
            'strerro' => $strErro
        ]);
    }

    public function sairAction()
    {
        $usuario = new Usuario();
        $table = $this->getServiceLocator()
        ->get('Application\Model\UsuarioTable');
        $table->sair();
        return $this->redirect()->toUrl('/application/usuario/login');
    }

    public function createAction()
    {
        $table = $this->getServiceLocator()
            ->get('Application\Model\UsuarioTable');

        
            
    	if ($this->getRequest()->isPost()) {
    		$data = $this->params()->fromPost();
    		$usuario = new Usuario();
    		$usuario->exchangeArray($data);

            if ($usuario->validaNome()
                && $usuario->validaUsuario()) {
    		    $table->insert($usuario);
                return $this->redirect()->toUrl('/application/usuario/index');
            } else {
                $erros = $usuario->getArrErros();
            }
    	}

    	return new ViewModel([
            'erros' => $erros
        ]);
    }

    public function editAction()
    {
        $table = $this->getServiceLocator()
    		->get('Application\Model\UsuarioTable');

        if ($table->verificar() === false) {
            return $this->redirect()->toUrl('/application/usuario/login');
        }
               
        $erros = "";
            
    	if ($this->getRequest()->isPost()) {
    		$data = $this->params()->fromPost();
    		$usuario = new Usuario();
    	    $usuario->exchangeArray($data);

            if ($usuario->validaNome()
                && $usuario->validaUsuario()) {
        		$table->update($usuario);
        		return $this->redirect()->toUrl('/application/usuario/index');
            } else {
                $erros = $usuario->getArrErros();
            }
    	}

    	$usuario = $table->find($this->params()->fromRoute('id'));

    	return new ViewModel([
    		'cliente' => $usuario,
            'erros' => $erros
    	]);
    }

    public function deleteAction()
    {
    	$table = $this->getServiceLocator()
    		->get('Application\Model\UsuarioTable');
    	
        if ($table->verificar() === false) {
            return $this->redirect()->toUrl('/application/usuario/login');
        }

    	$usuario = $table->delete($this->params()->fromRoute('id'));
    	return $this->redirect()->toUrl('/application/usuario/index');
    }
}