<?php
namespace ZfcAdmin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class NewsFilter extends InputFilter {

    public function __construct() {
        	
		$this->add(array(
            'name' => 'title',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'description',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'image_path',
            'required'=> false,
        ));

        $this->add(array(
            'name' => 'news_category_id',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'IsActive',
            'required'=> true,
        ));

    }

}
