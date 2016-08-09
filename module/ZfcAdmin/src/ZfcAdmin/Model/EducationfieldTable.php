<?php

namespace ZfcAdmin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class EducationfieldTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getEducationfield($id) {
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

    public function deleteEducationfield($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveEducationfield($educationfieldEntity)
    {
    	$educationfieldEntity->created_date = (empty($educationfieldEntity->created_date))? date('Y-m-d h:i:s'):$educationfieldEntity->created_date;
                $educationfieldEntity->modified_date = (empty($educationfieldEntity->modified_date))? date('Y-m-d h:i:s'):$educationfieldEntity->modified_date;

    	$data = array(
            'education_field' => $educationfieldEntity->education_field,
    		'IsActive' => $educationfieldEntity->IsActive,
    		'created_date' => $educationfieldEntity->created_date,
    		'modified_date' => $educationfieldEntity->modified_date,
    		'modified_by' => "1"
    		);
        if($educationfieldEntity->id==0){
            $resultSet = $this->tableGateway->insert($data);
        }
        else {
            if ($this->getEducationfield($educationfieldEntity->id)) {


                    $this->tableGateway->update($data, array('id' => $educationfieldEntity->id));

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
