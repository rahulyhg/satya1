<?php

namespace ZfcAdmin\Model\Entity;

class Newses {

    public $id;
    public $title;
    public $description;
    public $IsActive;
    public $news_category_id;
    public $category_name;
    public $username;
    public $image;
    public $image_path;
    public $created_date;
    public $modified_date;
    public $modified_by;

    public function exchangeArray($data) {

        $this->id = (!empty($data['id'])) ? $data['id'] : null;

        $this->title = (!empty($data['title'])) ? $data['title'] : null;

        $this->description = (!empty($data['description'])) ? $data['description'] : null;

        $this->IsActive = (!empty($data['IsActive'])) ? $data['IsActive'] : null;

        $this->news_category_id = (!empty($data['news_category_id'])) ? $data['news_category_id'] : null;

        $this->category_name = (!empty($data['category_name'])) ? $data['category_name'] : null;

        $this->image = (!empty($data['image'])) ? $data['image'] : null;
        
        $this->image_path = (!empty($data['image_path'])) ? $data['image_path'] : null;

        $this->created_date = (!empty($data['created_date'])) ? $data['created_date'] : null;
        
        $this->modified_date = (!empty($data['modified_date'])) ? $data['modified_date'] : null;

        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        
        $this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
        
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
   