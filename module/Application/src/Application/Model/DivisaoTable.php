<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class DivisaoTable
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
        $resultSet = $this->tableGateway->select(['codigo_divisao' => $id]);
        $object = $resultSet->current();
        return $object;
    }
    
    public function insert(Divisao $divisao)
    {
        $this->tableGateway->insert($divisao->getArrayCopy());
    }
    
    public function update(Divisao $divisao)
    {
        $oldDivisao = $this->find($divisao->getId());
        
        if ($oldDivisao) {
            $this->tableGateway->update($divisao->getArrayCopy(),
                ['codigo_divisao' => $oldDivisao->getId()]);
        } else {
          throw new \Exception("Divisao não encontrada");
       }
    }

    public function delete($id)
    {
        $this->tableGateway->delete(['codigo_divisao' => $id]);
    }

}