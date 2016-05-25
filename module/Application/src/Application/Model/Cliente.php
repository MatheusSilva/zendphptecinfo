<?php

namespace Application\Model;

class Cliente
{
	private $id;
	private $nome;
	private $cep;
	private $endereco;
	private $numero;
	private $complemento;
	private $cidade;
	private $bairro;
	private $estado;
	private $telefone;
	private $email;

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
     * Gets the value of cep.
     *
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Sets the value of cep.
     *
     * @param mixed $cep the cep
     *
     * @return self
     */
    private function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Gets the value of endereco.
     *
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Sets the value of endereco.
     *
     * @param mixed $endereco the endereco
     *
     * @return self
     */
    private function setEndereco($endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Gets the value of numero.
     *
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Sets the value of numero.
     *
     * @param mixed $numero the numero
     *
     * @return self
     */
    private function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Gets the value of complemento.
     *
     * @return mixed
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Sets the value of complemento.
     *
     * @param mixed $complemento the complemento
     *
     * @return self
     */
    private function setComplemento($complemento)
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Gets the value of cidade.
     *
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Sets the value of cidade.
     *
     * @param mixed $cidade the cidade
     *
     * @return self
     */
    private function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Gets the value of bairro.
     *
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Sets the value of bairro.
     *
     * @param mixed $bairro the bairro
     *
     * @return self
     */
    private function setBairro($bairro)
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Gets the value of estado.
     *
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Sets the value of estado.
     *
     * @param mixed $estado the estado
     *
     * @return self
     */
    private function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Gets the value of telefone.
     *
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Sets the value of telefone.
     *
     * @param mixed $telefone the telefone
     *
     * @return self
     */
    private function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    private function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

	public function exchangeArray(array $data)
    {
		$this->setId(isset($data['id'])?$data['id']:0)
			->setNome($data['nome'])
			->setCep($data['cep'])
			->setEndereco($data['endereco'])
			->setNumero($data['numero'])
			->setComplemento($data['complemento'])
			->setCidade($data['cidade'])
			->setBairro($data['bairro'])
			->setEstado($data['estado'])
			->setTelefone($data['telefone'])
			->setEmail($data['email']);
	}

	public function getArrayCopy()
    {
		return [
			'id' => $this->getId(),
			'nome' => $this->getNome(),
			'cep' => $this->getCep(),
			'endereco' => $this->getEndereco(),
			'numero' => $this->getNumero(),
			'complemento' => $this->getComplemento(),
			'cidade' => $this->getCidade(),
			'bairro' => $this->getBairro(),
			'estado' => $this->getEstado(),
			'telefone' => $this->getTelefone(),
			'email' => $this->getEmail()
		];
	}

}