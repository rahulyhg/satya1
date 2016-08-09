<?php

namespace ZfcAdmin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class DesignationTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getDesignation($id) {
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

    public function deleteDesignation($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveDesignation($designationEntity)
    {
    	$designationEntity->created_date = (empty($designationEntity->created_date))? date('Y-m-d h:i:s'):$designationEntity->created_date;
                $designationEntity->modified_date = (empty($designationEntity->modified_date))? date('Y-m-d h:i:s'):$designationEntity->modified_date;

    	$data = array(
            'designation' => $designationEntity->designation,
    		'IsActive' => $designationEntity->IsActive,
    		'created_date' => $designationEntity->created_date,
    		'modified_date' => $designationEntity->modified_date,
    		'modified_by' => "1"
    		);
        if($designationEntity->id==0){
            $resultSet = $this->tableGateway->insert($data);
        }
        else {
            if ($this->getDesignation($designationEntity->id)) {


                    $this->tableGateway->update($data, array('id' => $designationEntity->id));

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
