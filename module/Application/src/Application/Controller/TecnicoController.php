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
use Application\Model\Tecnico;

class TecnicoController extends AbstractActionController
{
    public function indexAction()
    {
        $table = $this->getServiceLocator()
            ->get('Application\Model\UsuarioTable');

        if ($table->verificar() === false) {
            return $this->redirect()->toUrl('/application/usuario/login');
        }
        
    	$tecnicos = $this->getServiceLocator()
    	->get('Application\Model\TecnicoTable')->findAll();
        return new ViewModel([
        	'clientes' => $tecnicos
        ]);
    }

    public function createAction()
    {
        $table = $this->getServiceLocator()
            ->get('Application\Model\UsuarioTable');

        if ($table->verificar() === false) {
            return $this->redirect()->toUrl('/application/usuario/login');
        }

    	if ($this->getRequest()->isPost()) {
    		$data = $this->params()->fromPost();
    		$tecnico = new Tecnico();
    		$tecnico->exchangeArray($data);
    		$table = $this->getServiceLocator()
    		->get('Application\Model\TecnicoTable');

            $erros = "";

            if ($tecnico->validaNome()) {
        		$table->insert($tecnico);
        	    return $this->redirect()->toUrl('/application/tecnico/index');
            } else {
                $erros = $tecnico->getArrErros();
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

    	$table = $this->getServiceLocator()
    		->get('Application\Model\TecnicoTable');

        $erros = "";
            
    	if ($this->getRequest()->isPost()) {
    		$data = $this->params()->fromPost();
    		$tecnico = new Tecnico();
    		$tecnico->exchangeArray($data);
            
            if ($tecnico->validaNome()) {
    	        $table->update($tecnico);
    		    return $this->redirect()->toUrl('/application/tecnico/index');
            } else {
                $erros = $tecnico->getArrErros();
            }
    	}

    	$tecnico = $table->find($this->params()->fromRoute('id'));

    	return new ViewModel([
    		'cliente' => $tecnico,
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

    	$table = $this->getServiceLocator()
    		->get('Application\Model\TecnicoTable');
    	
    	$tecnico = $table->delete($this->params()->fromRoute('id'));
    	return $this->redirect()->toUrl('/application/tecnico/index');
    }
}