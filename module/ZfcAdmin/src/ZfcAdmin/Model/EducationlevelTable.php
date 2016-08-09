<?php

namespace ZfcAdmin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class EducationlevelTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getEducationlevel($id) {
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

    public function deleteEducationlevel($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveEducationlevel($educationlevelEntity)
    {
    	$educationlevelEntity->created_date = (empty($educationlevelEntity->created_date))? date('Y-m-d h:i:s'):$educationlevelEntity->created_date;
                $educationlevelEntity->modified_date = (empty($educationlevelEntity->modified_date))? date('Y-m-d h:i:s'):$educationlevelEntity->modified_date;

    	$data = array(
            'education_level' => $educationlevelEntity->education_level,
    		'IsActive' => $educationlevelEntity->IsActive,
    		'created_date' => $educationlevelEntity->created_date,
    		'modified_date' => $educationlevelEntity->modified_date,
    		'modified_by' => "1"
    		);
        if($educationlevelEntity->id==0){
            $resultSet = $this->tableGateway->insert($data);
        }
        else {
            if ($this->getEducationlevel($educationlevelEntity->id)) {


                    $this->tableGateway->update($data, array('id' => $educationlevelEntity->id));

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
