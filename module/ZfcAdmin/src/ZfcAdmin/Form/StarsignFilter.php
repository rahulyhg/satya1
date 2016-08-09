<?php
namespace ZfcAdmin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class StarsignFilter extends InputFilter {

    public function __construct() {
        	
		

        $this->add(array(
            'name' => 'star_sign_name',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'IsActive',
            'required'=> true,
        ));

    }

}
