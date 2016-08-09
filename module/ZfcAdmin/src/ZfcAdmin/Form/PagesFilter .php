<?php
namespace ZfcAdmin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class PagesFilter extends InputFilter {

    public function __construct() {
            
        $this->add(array(
            'name' => 'page_title',
            'required'=> true,
        ));

         $this->add(array(
            'name' => 'page_content',
            'required'=> true,
        ));

        //  $this->add(array(
        //     'name' => 'tab_id',
        //     'required'=> false,
        // ));
        

        $this->add(array(
            'name' => 'IsActive',
            'required'=> true,
        ));

    }

}
