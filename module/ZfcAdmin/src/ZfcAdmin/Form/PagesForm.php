<?php
namespace ZfcAdmin\Form;

use Zend\Form\Form;

class PagesForm extends Form {

    // public static $state_nameList = array();
    // public static $country_nameList = array();


    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('tbl_static_pages');
        $this->setAttribute('method', 'post');
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'tab_id',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control',
                'id'=>'tab_id'
            ),
            'options' => array(
                'label' => 'Tab Id',
            ),
        ));

        $this->add(array(
            'name' => 'page_title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'page_title'
            ),
            'options' => array(
                'label' => 'Page Title',
            ),
        ));

        $this->add(array(
        'type' => 'Hidden',
        'name' => 'page_content',
        'attributes' => array(
                'id'=>'page_content'
        ),
        'options' => array(
            'label' => 'Page Content',
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
        'empty_option' => 'Please Select Status',
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
