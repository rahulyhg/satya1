<?php

namespace ZfcAdmin\Model\Entity;

class AllPages {

    public $id;
    public $tab_id;
    public $page_title;
    public $page_content;
    public $IsActive;
    public $created_date;
    public $modified_date;
    public $modified_by;
    public $created_by;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->tab_id = (!empty($data['tab_id'])) ? $data['tab_id'] : null;

        $this->page_title = (!empty($data['page_title'])) ? $data['page_title'] : null;

        $this->page_content = (!empty($data['page_content'])) ? $data['page_content'] : null;

        $this->IsActive = (!empty($data['IsActive'])) ? $data['IsActive'] : null;

        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
        
        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;

        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
        
        $this->created_by = (!empty($data['created_by'])) ? $data['created_by'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   