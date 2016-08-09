<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ReligionTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();

        return $resultSet;
    }

    public function getReligion($id) {
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

    public function deleteReligion($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveReligion($religionEntity)
    {
    	$religionEntity->created_date = (empty($religionEntity->created_date))? date('Y-m-d h:i:s'):$religionEntity->created_date;
                $religionEntity->modified_date = (empty($religionEntity->modified_date))? date('Y-m-d h:i:s'):$religionEntity->modified_date;

    	$data = array(
            'religion_name' => $religionEntity->religion_name,
    		'IsActive' => $religionEntity->IsActive,
    		'created_date' => $religionEntity->created_date,
    		'modified_date' => $religionEntity->modified_date,
    		'modified_by' => "1"
    		);
        if($religionEntity->id==0){
            $resultSet = $this->tableGateway->insert($data);
        }
        else {
            if ($this->getReligion($religionEntity->id)) {

                    $this->tableGateway->update($data, array('id' => $religionEntity->id));

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
