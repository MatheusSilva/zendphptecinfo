<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Cliente;
use Application\Model\ClienteTable;
use Application\Model\Categoria;
use Application\Model\CategoriaTable;
use Application\Model\Divisao;
use Application\Model\DivisaoTable;
use Application\Model\Tecnico;
use Application\Model\TecnicoTable;
use Application\Model\Usuario;
use Application\Model\UsuarioTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig(){
        return [
            'factories' => array(
                'Application\Model\ClienteTable' => function($sm){
                    $tableGateway = $sm->get('ClienteTableGateway');
                    $table = new ClienteTable($tableGateway);
                    return $table;
                },
                'ClienteTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Cliente());
                    return new TableGateway('clientes',$dbAdapter,
                        null,$resultSetPrototype);
                },
                'Application\Model\CategoriaTable' => function($sm){
                    $tableGateway = $sm->get('CategoriaTableGateway');
                    $table = new CategoriaTable($tableGateway);
                    return $table;
                },
                'CategoriaTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Categoria());
                    return new TableGateway('categoria',$dbAdapter,
                        null,$resultSetPrototype);
                },
                'Application\Model\DivisaoTable' => function($sm){
                    $tableGateway = $sm->get('DivisaoTableGateway');
                    $table = new DivisaoTable($tableGateway);
                    return $table;
                },
                'DivisaoTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Divisao());
                    return new TableGateway('divisao',$dbAdapter,
                        null,$resultSetPrototype);
                },
                'Application\Model\TecnicoTable' => function($sm){
                    $tableGateway = $sm->get('TecnicoTableGateway');
                    $table = new TecnicoTable($tableGateway);
                    return $table;
                },
                'TecnicoTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Tecnico());
                    return new TableGateway('tecnico',$dbAdapter,
                        null,$resultSetPrototype);
                },
                'Application\Model\UsuarioTable' => function($sm) {
                    $tableGateway = $sm->get('UsuarioTableGateway');
                    $table = new UsuarioTable($tableGateway);
                    return $table;
                },
                'UsuarioTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Usuario());
                    return new TableGateway('torcedor',$dbAdapter,
                        null,$resultSetPrototype);
                }
            )
        ];
    }
}
