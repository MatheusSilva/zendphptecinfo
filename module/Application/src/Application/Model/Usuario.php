<?php

namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class Usuario
{
	private $id;
	private $nome;
    private $login;
    private $senha;
    private $arrErros;

	/**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    private function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Gets the value of nome.
     *
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Sets the value of nome.
     *
     * @param mixed $nome the nome
     *
     * @return self
     */
    private function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Gets the value of nome.
     *
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Sets the value of nome.
     *
     * @param mixed $nome the nome
     *
     * @return self
     */
    private function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Gets the value of nome.
     *
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Sets the value of nome.
     *
     * @param mixed $nome the nome
     *
     * @return self
     */
    private function setSenha($senha)
    {
        $salt1 = "15353oiwHSDDKFJNGmfnsjfjqbhdgkjk";
        $salt2 = "NSBDFSDBFisoetiihskkdfgjfdkj56767";
        $this->senha = hash('sha512', $salt1.$senha.$salt2);
        return $this;
    }


    /**
     * Gets the value of nome.
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Sets the value of nome.
     *
     * @param mixed $nome the nome
     *
     * @return self
     */
    private function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Gets the value of nome.
     *
     * @return mixed
     */
    public function getArrErros()
    {
        return $this->arrErros;
    }

    /**
     * Sets the value of nome.
     *
     * @param mixed $nome the nome
     *
     * @return self
     */
    private function setArrErros($arrErros)
    {
        $this->arrErros = $arrErros;

        return $this;
    }

	public function exchangeArray(array $data)
    {
		$this->setId(isset($data['codigo_torcedor'])?$data['codigo_torcedor']:0)
            ->setLogin($data['login'])
            ->setSenha($data['senha'])
			->setNome($data['nome'])
            ->setToken(isset($data['token'])?$data['token']:'');
	}

	public function getArrayCopy()
    {
		return [
			'codigo_torcedor' => $this->getId(),
            'login' => $this->getLogin(),
            'senha' => $this->getSenha(),
			'nome' => $this->getNome(),
            'token' => $this->getToken(),
		];
	}
    
    public function validaNome()
    {
        $factory = new InputFactory();
        $inputFilter = new InputFilter();
        
        $inputFilter->add($factory->createInput(array(
            'name'     => 'nome',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 2,
                        'max'      => 100,
                        'messages' => array(
                            \Zend\Validator\StringLength::INVALID => 'Tipo inválido dado. string esperado.',
                            \Zend\Validator\StringLength::TOO_SHORT => 'O campo nome deve ter pelo menos %min% caracteres.',
                            \Zend\Validator\StringLength::TOO_LONG => 'O campo nome não pode ter mais do que %max% caracteres.'
                        )
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => 'O campo nome deve ser preenchido.'
                        )
                    )
                ),
            ),
        )));

        $inputFilter->setData([
            'nome' => $this->getNome()
        ]);

        if ($inputFilter->isValid()) {
            return true;
        } else {
            $this->setArrErros($inputFilter->getMessages());
            return false;
        }//if ($inputFilter->isValid()) {
    }//ublic function validaNome()

    public function validaUsuario()
    {
        $factory = new InputFactory();
        $inputFilter = new InputFilter();
        
        $inputFilter->add($factory->createInput(array(
            'name'     => 'usuario',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 4,
                        'max'      => 40,
                        'messages' => array(
                            \Zend\Validator\StringLength::INVALID => 'Tipo inválido dado. string esperado.',
                            \Zend\Validator\StringLength::TOO_SHORT => 'O campo usuario deve ter pelo menos %min% caracteres.',
                            \Zend\Validator\StringLength::TOO_LONG => 'O campo usuario não pode ter mais do que %max% caracteres.'
                        )
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => 'O campo usuario deve ser preenchido.'
                        )
                    )
                ),
            ),
        )));

        $inputFilter->setData([
            'usuario' => $this->getLogin()
        ]);

        if ($inputFilter->isValid()) {
            return true;
        } else {
            $this->setArrErros($inputFilter->getMessages());
            return false;
        }//if ($inputFilter->isValid()) {
    }//ublic function validaUsuario()
}