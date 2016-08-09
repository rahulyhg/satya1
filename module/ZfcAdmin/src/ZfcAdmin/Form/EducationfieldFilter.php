<?php
namespace ZfcAdmin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class EducationfieldFilter extends InputFilter {

    public function __construct() {
        	
        $this->add(array(
            'name' => 'education_field',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'IsActive',
            'required'=> true,
        ));

    }

}
