<?php
namespace Admin\Form;

use Zend\Form\Form;

class ZodiacsignForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('tbl_zodiac_sign_raasi');
        $this->setAttribute('method', 'post');
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'zodiac_sign_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'zodiac_sign_name'
            ),
            'options' => array(
                'label' => 'Zodiac Sign Name',
            ),
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
        'empty_option'=> 'Please Select Status',    
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
