<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ProfessionTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getProfession($id) {
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

    public function deleteProfession($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveProfession($professionEntity)
    {
    	$professionEntity->created_date = (empty($professionEntity->created_date))? date('Y-m-d h:i:s'):$professionEntity->created_date;
                $professionEntity->modified_date = (empty($professionEntity->modified_date))? date('Y-m-d h:i:s'):$professionEntity->modified_date;

    	$data = array(
            'profession' => $professionEntity->profession,
    		'IsActive' => $professionEntity->IsActive,
    		'created_date' => $professionEntity->created_date,
    		'modified_date' => $professionEntity->modified_date,
    		'modified_by' => "1"
    		);
        if($professionEntity->id==0){
            $resultSet = $this->tableGateway->insert($data);
        }
        else {
            if ($this->getProfession($professionEntity->id)) {


                    $this->tableGateway->update($data, array('id' => $professionEntity->id));

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
