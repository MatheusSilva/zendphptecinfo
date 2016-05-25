<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoriaTable
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
		$resultSet = $this->tableGateway->select(['codigo_categoria' => $id]);
		$object = $resultSet->current();
		return $object;
	}

	public function insert(Categoria $cliente)
	{
		$this->tableGateway->insert($cliente->getArrayCopy());
	}

	public function update(Categoria $cliente)
	{
		$oldCategoria = $this->find($cliente->getId());
		
		if ($oldCategoria) {
			$this->tableGateway->update($cliente->getArrayCopy(),
				['codigo_categoria' => $oldCategoria->getId()]);
		} else {
		  throw new \Exception("Categoria não encontrada");
	   }
	}

	public function delete($id)
	{
		$this->tableGateway->delete(['codigo_categoria' => $id]);
	}

}