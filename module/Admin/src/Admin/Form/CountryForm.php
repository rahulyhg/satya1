<?php

namespace Admin\Form;

use Zend\Form\Form;

class CountryForm extends Form {

    public static $actionName = "";

    public function __construct($name = null) {
        
    
        // we want to ignore the name passed
        parent::__construct('tbl_country');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'master_country_id',
            'type' => 'Hidden',
            'attributes' => array(
                'id' => 'master_country_id'
            ),
        ));

        $this->add(array(
            'name' => 'country_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'onkeyup' => 'keyupresults($(this).val(),searchboxresults,$(this).parent().attr("id"),"' . self::$actionName . '")',
                'id' => 'country_name'
            ),
            'options' => array(
                'label' => 'Country Name',
            ),
        ));
        $this->add(array(
            'name' => 'dial_code',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control',
                'id' => 'dial_code'
            ),
            'options' => array(
                'label' => 'Dial Code',
            ),
        ));

        $this->add(array(
            'name' => 'country_code',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'country_code'
            ),
            'options' => array(
                'label' => 'Country Code',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'IsActive',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'IsActive'
            ),
            'options' => array(
                'label' => 'Status',
                'value_options' => array(
                    '1' => 'Active',
                    '0' => 'In Active'),
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Contact Us',
                'id' => 'submit',
                'class' => 'btn btn-default'
            ),
        ));
    }

}
