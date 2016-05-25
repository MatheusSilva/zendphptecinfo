<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class UsuarioTable
{
	private $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function findAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function find($id)
	{
		$resultSet = $this->tableGateway->select(['codigo_torcedor' => $id]);
		$object = $resultSet->current();
		return $object;
	}

	public function insert(Usuario $usuario)
	{
		$this->tableGateway->insert($usuario->getArrayCopy());
	}

	public function update(Usuario $usuario)
	{
		$oldUsuario = $this->find($usuario->getId());
		
		if ($oldUsuario) {
			$this->tableGateway->update($usuario->getArrayCopy(),
				['codigo_torcedor' => $oldUsuario->getId()]);
		} else {
		  throw new \Exception("Usuario não encontrado");
	   }
	}

	public function delete($id)
	{
		$this->tableGateway->delete(['codigo_torcedor' => $id]);
	}

	/**
    * metodo que busca o ip real do usuario
    *
    * @access    public
    * @return    string Retorna o ip do usuario
    * @author    Matheus Silva
    * @copyright © Copyright 2016 Matheus Silva. Todos os direitos reservados.
    * @since     27/04/2016
    * @version   0.1
    */
    public function retornaIpUsuario()
    {
        $http_client_ip = "";
        $http_x_forwarded_for = "";
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $http_client_ip       = $_SERVER['HTTP_CLIENT_IP'];
        }//if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }//if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $remote_addr          = $_SERVER['REMOTE_ADDR'];
         
        /* verifica se o ip existe */
        if (!empty($http_client_ip)) {
            $ip = $http_client_ip;
            /* verifica se o acesso é de um servidor proxy */
        } elseif (!empty($http_x_forwarded_for)) {
            $ip = $http_x_forwarded_for;
        } else {
            /* caso contrario pega o ip normal do usuario */
            $ip = $remote_addr;
        }
        return $ip;
    }//public static function retornaIpUsuario()

    /**
    * metodo que verifica se o usuario esta logado
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2016 Matheus Silva. Todos os direitos reservados.
    * @since     27/04/2016
    * @version   0.1
    */
    public function estaLogado()
    {
        if (!isset($_SESSION)) {
            session_start();
        }//if (!isset($_SESSION)) {
        
        if (isset($_SESSION['logado'])
        && $_SESSION['logado'] == 'ok'
        && $_SESSION['agentUser'] == $_SERVER['HTTP_USER_AGENT']
        && $_SESSION['ip'] == self::retornaIpUsuario()
        && isset($_COOKIE['token'])) {
            return true;
        }

        return false;
    }//public static function estaLogado()

    /**
    * metodo que verifica se o usuario esta logado
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2016 Matheus Silva. Todos os direitos reservados.
    * @since     27/04/2016
    * @version   0.1
    */
    public function verificar()
    {
        if (!isset($_SESSION)) {
            session_start();
        }//if (!isset($_SESSION)) {
        
        if (self::estaLogado()) {
        	$token = $_COOKIE["token"];
            setcookie("token", $token, time()+900, "/");
            return true;
        } else {
            self::sair();
        	return false;
        }
    }//public static function verificar($redirecionar = true)

    /**
    * metodo que faz o logout do usuario
    *
    * @access    public
    * @author    Matheus Silva
    * @copyright © Copyright 2016 Matheus Silva. Todos os direitos reservados.
    * @since     27/04/2016
    * @version   0.1
    */
    public function sair()
    {
        if (!isset($_SESSION)) {
            session_start();
        }//if (!isset($_SESSION)) {
            
        setcookie('token', null, -1, '/');
        $retorno = true;

        if (isset($_SESSION['u']) && !empty($_SESSION['u'])) {
        	$retorno = $this->tableGateway->update(array('token' => ''),
				array('login' => $_SESSION['u']));
        }
   		
        $_SESSION['logado']    = '';
        $_SESSION['u']         = '';
        $_SESSION['agentUser'] = '';
        $_SESSION['ip']        = '';
        session_destroy();
        return $retorno;
    }//public static function sair()

    /**
    * metodo que faz o login do usuario no sistema
    *
    * @access    public
    * @param     string $usuario Armazena o objeto usuario
    * @author    Matheus Silva
    * @copyright © Copyright 2016 Matheus Silva. Todos os direitos reservados.
    * @since     27/04/2016
    * @version   0.1
    */
    public function entrar(Usuario $usuario)
    {
    	$arrLoginSenha = array('login' => $usuario->getLogin(), 'senha' => $usuario->getSenha());
        $usuario = $this->tableGateway->select($arrLoginSenha)->current();

        if (empty($usuario) === false) {
			$salt1      = "jcxzknhxjajduhlJHDGHAQZkhyhmnk789553";
            $salt2      = "893343hjgsjhbjlAHLKJHIDJiertokrjtkr";
            $rand       = uniqid(rand(), true);
            $userAgent  = $_SERVER['HTTP_USER_AGENT'];
            $ip         = self::retornaIpUsuario();
            $token = hash('sha256', $userAgent.$salt2.$rand.$senha.$salt1.$ip);
        	$retornoUpdate = $this->tableGateway->update(array('token' => $token), $arrLoginSenha);
        	
            if ($retornoUpdate) {
                if (!isset($_SESSION)) {
                    session_start();
                }//if (!isset($_SESSION)) {
                
                $_SESSION['ip']               = $ip;
                $_SESSION['agentUser']        = $userAgent;
                $_SESSION['logado']           = 'ok';
                $_SESSION['u']                = $usuario->getLogin();
                setcookie("token", $token, time()+900, "/");
                return true;
            } else {
            	return false;
            }//if ($retornoUpdate) {
        }//if (empty($usuario) === false) {

        return false;
    }//public static function entrar(Usuario $usuario)
}