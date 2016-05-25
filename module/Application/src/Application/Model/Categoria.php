<?php

namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class Categoria
{
	private $id;
	private $nome;
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
		$this->setId(isset($data['codigo_categoria'])?$data['codigo_categoria']:0)
			->setNome($data['nome']);
	}

	public function getArrayCopy()
    {
		return [
			'codigo_categoria' => $this->getId(),
			'nome' => $this->getNome(),
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

}