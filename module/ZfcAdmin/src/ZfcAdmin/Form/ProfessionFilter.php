<?php
namespace ZfcAdmin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class ProfessionFilter extends InputFilter {

    public function __construct() {
        	
        $this->add(array(
            'name' => 'profession',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'IsActive',
            'required'=> true,
        ));

    }

}
