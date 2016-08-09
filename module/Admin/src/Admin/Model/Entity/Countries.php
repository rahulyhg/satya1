<?php

namespace Admin\Model\Entity;

class Countries {

    public $id;
    public $country_name;
    public $IsActive;
    public $dial_code;
    public $country_code;
    public $created_date;
    public $modified_date;
    public $modified_by;
    public $master_country_id;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->country_name = (!empty($data['country_name'])) ? $data['country_name'] : null;

        $this->IsActive = (!empty($data['IsActive'])) ? $data['IsActive'] : null;

        $this->dial_code = (!empty($data['dial_code'])) ? $data['dial_code'] : null;

        $this->country_code = (!empty($data['country_code'])) ? $data['country_code'] : null;

        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
        
        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;

        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
        
        $this->master_country_id = (!empty($data['master_country_id'])) ? $data['master_country_id'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   