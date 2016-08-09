<?php

namespace ZfcAdmin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class GothraTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();

        return $resultSet;
    }

    public function getGothra($id) {
        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
        return $resultSet;
    }

    // public function getStatejoin($id) {
    //     $resultSet = $this->tableGateway->select(function (Select $select) use($id){
    //         $select->where(array('tbl_state.id'=>$id));
    //         $select->join('tbl_country','tbl_state.country_id = tbl_country.id',array('country_name'));
    //     })->current();

    //     return $resultSet;
    // }

    public function deleteGothra($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveGothra($gothraEntity)
    {
    	$gothraEntity->created_date = (empty($gothraEntity->created_date))? date('Y-m-d h:i:s'):$gothraEntity->created_date;
                $gothraEntity->modified_date = (empty($gothraEntity->modified_date))? date('Y-m-d h:i:s'):$gothraEntity->modified_date;

    	$data = array(
            'gothra_name' => $gothraEntity->gothra_name,
    		'IsActive' => $gothraEntity->IsActive,
    		'created_date' => $gothraEntity->created_date,
    		'modified_date' => $gothraEntity->modified_date,
    		'modified_by' => "1"
    		);
        if($gothraEntity->id==0){
            $resultSet = $this->tableGateway->insert($data);
        }
        else {
            if ($this->getGothra($gothraEntity->id)) {


                    $this->tableGateway->update($data, array('id' => $gothraEntity->id));

                } else {
                    throw new \Exception('Users id does not exist');
                }
        }
    }

    //  public function customFields($columns)
    // {   
    //     $stateName = $this->tableGateway->select(function(Select $select) use($columns){
    //         $select->order('id ASC');
    //         $select->columns($columns);
    //     })->toArray();

    //     foreach ($stateName as $list) {
    //         $statenamelist[$list['id']] = $list['state_name'];
    //     }
    //     // print_r($statenamelist);die;
    //     return $statenamelist;
    // }

}
