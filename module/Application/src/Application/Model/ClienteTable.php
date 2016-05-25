<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ClienteTable
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
		$resultSet = $this->tableGateway->select(['id' => $id]);
		$object = $resultSet->current();
		return $object;
	}

	public function insert(Cliente $cliente)
	{
		$this->tableGateway->insert($cliente->getArrayCopy());
	}

	public function update(Cliente $cliente)
	{
		$oldCliente = $this->find($cliente->getId());
		
		if ($oldCliente) {
			$this->tableGateway->update($cliente->getArrayCopy(),
				['id' => $oldCliente->getId()]);
		} else {
		  throw new \Exception("Cliente não encontrado");
	   }
	}

	public function delete($id)
	{
		$this->tableGateway->delete(['id' => $id]);
	}

}