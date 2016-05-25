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
use Application\Model\Categoria;

class CategoriaController extends AbstractActionController
{
    public function indexAction()
    {
        $table = $this->getServiceLocator()
            ->get('Application\Model\UsuarioTable');
                    
        if ($table->verificar() === false) {
            return $this->redirect()->toUrl('/application/usuario/login');
        }

    	$table = $this->getServiceLocator()
    	->get('Application\Model\CategoriaTable')->findAll();
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
    		$categoria = new Categoria();
    		$categoria->exchangeArray($data);
    		$table = $this->getServiceLocator()
    		->get('Application\Model\CategoriaTable');

            $erros = "";

            if ($categoria->validaNome()) {
        		$table->insert($categoria);
        	    return $this->redirect()->toUrl('/application/categoria/index');
            } else {
                $erros = $categoria->getArrErros();
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
    		->get('Application\Model\CategoriaTable');

        $erros = "";
            
    	if ($this->getRequest()->isPost()) {
    		$data = $this->params()->fromPost();
    		$categoria = new Categoria();
    		$categoria->exchangeArray($data);

    		if ($categoria->validaNome()) {
                $table->update($categoria);
                return $this->redirect()->toUrl('/application/categoria/index');
            } else {
                $erros = $categoria->getArrErros();
            }
    	}

    	$categoria = $table->find($this->params()->fromRoute('id'));

    	return new ViewModel([
    		'cliente' => $categoria,
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
    		->get('Application\Model\CategoriaTable');
    	
    	$categoria = $table->delete($this->params()->fromRoute('id'));
    	return $this->redirect()->toUrl('/application/categoria/index');
    }
}
