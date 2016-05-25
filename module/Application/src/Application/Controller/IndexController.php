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
use Application\Model\Cliente;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return $this->redirect()->toUrl('/application/usuario');

    	$clientes = $this->getServiceLocator()
    	->get('Application\Model\ClienteTable')->findAll();
        return new ViewModel([
        	'clientes' => $clientes
        ]);
    }

    public function createAction()
    {
    	if ($this->getRequest()->isPost()) {
    		$data = $this->params()->fromPost();
    		$cliente = new Cliente();
    		$cliente->exchangeArray($data);
    		$table = $this->getServiceLocator()
    		->get('Application\Model\ClienteTable');
    		$table->insert($cliente);
    	    return $this->redirect()->toUrl('/application/index/index');
    	}

    	return new ViewModel();
    }
    
    public function editAction()
    {
    	$table = $this->getServiceLocator()
    		->get('Application\Model\ClienteTable');

    	if ($this->getRequest()->isPost()) {
    		$data = $this->params()->fromPost();
    		$cliente = new Cliente();
    		$cliente->exchangeArray($data);
    		$table->update($cliente);
    		return $this->redirect()->toUrl('/application/index/index');
    	}
        
    	$cliente = $table->find($this->params()->fromRoute('id'));
        
    	return new ViewModel([
    		'cliente' => $cliente
    	]);
    }

    public function deleteAction()
    {
    	$table = $this->getServiceLocator()
    		->get('Application\Model\ClienteTable');
    	
    	$cliente = $table->delete($this->params()->fromRoute('id'));
    	return $this->redirect()->toUrl('/application/index/index');
    }
}
