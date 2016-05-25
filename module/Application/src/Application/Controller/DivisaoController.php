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
use Application\Model\Divisao;

class DivisaoController extends AbstractActionController
{
    public function indexAction()
    {
        $table = $this->getServiceLocator()
            ->get('Application\Model\UsuarioTable');

        if ($table->verificar() === false) {
            return $this->redirect()->toUrl('/application/usuario/login');
        }
        
    	$table = $this->getServiceLocator()
    	->get('Application\Model\DivisaoTable')->findAll();
        return new ViewModel([
        	'clientes' => $table
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
    		$divisao = new Divisao();
    		$divisao->exchangeArray($data);
    		$table = $this->getServiceLocator()
    		->get('Application\Model\DivisaoTable');

            $erros = "";

            if ($divisao->validaNome()) {
        		$table->insert($divisao);
        	    return $this->redirect()->toUrl('/application/divisao/index');
            } else {
                $erros = $divisao->getArrErros();
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
    		->get('Application\Model\DivisaoTable');

        $erros = "";
            
    	if ($this->getRequest()->isPost()) {
    		$data = $this->params()->fromPost();
    		$divisao = new Divisao();
    		$divisao->exchangeArray($data);

            if ($divisao->validaNome()) {
    		    $table->update($divisao);
    		    return $this->redirect()->toUrl('/application/divisao/index');
            } else {
                $erros = $divisao->getArrErros();
            }
    	}

    	$divisao = $table->find($this->params()->fromRoute('id'));

    	return new ViewModel([
    		'cliente' => $divisao,
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
    		->get('Application\Model\DivisaoTable');
    	
    	$divisao = $table->delete($this->params()->fromRoute('id'));
    	return $this->redirect()->toUrl('/application/divisao/index');
    }
}