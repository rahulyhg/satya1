<?php

namespace ZfcAdmin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class UsertypeTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function fetchAllActive() {
        $resultSet = $this->tableGateway->select(function(Select $select){
            $select->where('IsActive=1');
        });
        return $resultSet;
    }

    public function getUsertype($id) {
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

    public function deleteUsertype($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function updateUsertype($uid,$utype) {
        $resultSet = $this->tableGateway->update($utype,array('user_id'=>$uid));
        if($resultSet){
            $respArr = array('status'=>"Updated SuccessFully");
        }   
            
        else $respArr = array('status'=>"Couldn't update");

        return $respArr;
    }

    public function SaveUsertype($usertypeEntity)
    {
    	$usertypeEntity->created_date = (empty($usertypeEntity->created_date))? date('Y-m-d h:i:s'):$usertypeEntity->created_date;
                $usertypeEntity->modified_date = (empty($usertypeEntity->modified_date))? date('Y-m-d h:i:s'):$usertypeEntity->modified_date;

    	$data = array(
            'user_type' => $usertypeEntity->user_type,
    		'IsActive' => $usertypeEntity->IsActive,
    		'created_date' => $usertypeEntity->created_date,
    		'modified_date' => $usertypeEntity->modified_date,
    		'modified_by' => "1"
    		);
        if($usertypeEntity->id==0){
            $resultSet = $this->tableGateway->insert($data);
        }
        else {
            if ($this->getUsertype($usertypeEntity->id)) {


                    $this->tableGateway->update($data, array('id' => $usertypeEntity->id));

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
