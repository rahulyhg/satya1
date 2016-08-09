<?php

namespace ZfcAdmin\Model\Entity;

class Zodiacsigns {

    public $id;
    public $zodiac_sign_name;
    public $IsActive;
    public $created_date;
    public $modified_date;
    public $modified_by;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->zodiac_sign_name = (!empty($data['zodiac_sign_name'])) ? $data['zodiac_sign_name'] : null;

        $this->IsActive = (!empty($data['IsActive'])) ? $data['IsActive'] : null;

        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
        
        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;

        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   