<?php
namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class CountryFilter extends InputFilter {

    public function __construct() {
        	
		$this->add(array(
            'name' => 'country_name',
            'required'=> true,
        ));

		$this->add(array(
            'name' => 'dial_code',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'country_code',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'IsActive',
            'required'=> true,
        ));

    }

}
