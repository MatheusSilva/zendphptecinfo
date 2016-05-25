<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class TecnicoTable
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
        $resultSet = $this->tableGateway->select(['codigo_tecnico' => $id]);
        $object = $resultSet->current();
        return $object;
    }
    
    public function insert(Tecnico $tecnico)
    {
        $this->tableGateway->insert($tecnico->getArrayCopy());
    }
    
    public function update(Tecnico $tecnico)
    {
        $oldTecnico = $this->find($tecnico->getId());
        
        if ($oldTecnico) {
            $this->tableGateway->update($tecnico->getArrayCopy(),
                ['codigo_tecnico' => $oldTecnico->getId()]);
        } else {
          throw new \Exception("Tecnico não encontrada");
       }
    }

    public function delete($id)
    {
        $this->tableGateway->delete(['codigo_tecnico' => $id]);
    }

}