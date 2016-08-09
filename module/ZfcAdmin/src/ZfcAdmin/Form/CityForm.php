<?php
namespace ZfcAdmin\Form;

use Zend\Form\Form;

class CityForm extends Form {

    public static $state_nameList = array();
    public static $country_nameList = array();


    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('tbl_city');
        $this->setAttribute('method', 'post');
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'city_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'city_name'
            ),
            'options' => array(
                'label' => 'City Name',
            ),
        ));

        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'state_id',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'state_id'
        ),
        'options' => array(
            'label' => 'State Name',
        'empty_option' => 'Please Select State Name',
        'value_options' =>  self::$state_nameList,
        )
        ));

        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'country_id',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'country_id'
        ),
        'options' => array(
            'label' => 'Country Name',
        'empty_option' => 'Please Select Country Name',
        'value_options' =>  self::$country_nameList,
        )
        ));

        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'IsActive',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'IsActive'
        ),
        'options' => array(
            'label' => 'Status',
        'value_options' =>  array(
            '1'=>'Active',
            '0'=>'In Active'),
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
