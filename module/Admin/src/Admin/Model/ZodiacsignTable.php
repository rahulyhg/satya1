<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ZodiacsignTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        

        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getZodiacsign($id) {
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

    public function deleteZodiacsign($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveZodiacsign($zodiacsignEntity)
    {
    	$zodiacsignEntity->created_date = (empty($zodiacsignEntity->created_date))? date('Y-m-d h:i:s'):$zodiacsignEntity->created_date;
                $zodiacsignEntity->modified_date = (empty($zodiacsignEntity->modified_date))? date('Y-m-d h:i:s'):$zodiacsignEntity->modified_date;

    	$data = array(
            'zodiac_sign_name' => $zodiacsignEntity->zodiac_sign_name,
    		'IsActive' => $zodiacsignEntity->IsActive,
    		'created_date' => $zodiacsignEntity->created_date,
    		'modified_date' => $zodiacsignEntity->modified_date,
    		'modified_by' => "1"
    		);
        if($zodiacsignEntity->id==0){
            $resultSet = $this->tableGateway->insert($data);
        }
        else {
            if ($this->getZodiacsign($zodiacsignEntity->id)) {


                    $this->tableGateway->update($data, array('id' => $zodiacsignEntity->id));

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
