<?php
namespace Application\Form;

use Zend\Form\Form;

class MemberbasicForm extends Form { 	 
	   
	    public static $gothra_nameList=array();
		public static $religion_nameList=array();
		public static $blood_group=array();
		public static $marital_status=array();
		public static $country_nameList=array();
		public static $state_nameList=array();
		public static $city_nameList=array();
		public static $heightList=array();
        public static $Age_List=array();	
		public static $Name_Title=array();		
		public static $gender=array("Male"=>"Male","Female"=>"Female");
		public static $disability=array("None"=>"None","Physical disability"=>"Physical disability");
		public static $Profile_For=array("Myself"=>"Myself",
										"Brother"=>"Brother",
										"Sister"=>"Sister",
										"Son"=>"Son",
										"Daughter"=>"Daughter",
										"Cousin"=>"Cousin",
										"Others"=>"Others");
		public static $body_type=array("Average"=>"Average",
										"Athletic"=>"Athletic",
										"Slim"=>"Slim",
										"Heavy"=>"Heavy");
		public static $skin_tone=array("Very Fair"=>"Very Fair",
										"Fair"=>"Fair",
										"Wheatish"=>"Wheatish",
										"Dark"=>"Dark");
        public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
		$this->setAttribute('id', 'MemberbasicForm');
        $this->setAttribute('class', 'custom_error');
		//$this->setAttribute('action', 'EditPersonalInfo');
		
		$this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
		/* $this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'marital_status',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'marital_status'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$marital_status,
		)
		)); */
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'profile_for',
            'attributes' => array(                
                'id'=>'profile_for',
				'class'=>'form-control'
            ),
            'options' => array(
			'empty_option' => 'Select User',
			'value_options' =>  self::$Profile_For,
			)
        ));
		$this->add(array(
            'name' => 'profile_for_others',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'profile_for_others'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'name_title_user',
            'attributes' => array(                
                'id'=>'name_title_user',
				'class'=>'form-control tileF'
            ),
            'options' => array(
			'empty_option' => 'Select User',
			'value_options' =>  self::$Name_Title,
			)
        ));
		 $this->add(array(
            'name' => 'full_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'full_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
            'name' => 'alternate_mobile_no',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'alternate_mobile_no'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
            'name' => 'phone_no',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'phone_no'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));	
		
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'gender',
            'attributes' => array(                
                'id'=>'gender',
				'class'=>'form-control'
            ),
            'options' => array(
			'empty_option' => 'Select Your Gender',
			'value_options' =>  self::$gender,
			)
        )); 
		$this->add(array(
            'name' => 'dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control inputDate',
                'id'=>'dob',
				'readonly'=>'readonly'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'age',
            'attributes' => array(                
                'id'=>'age',
				'class'=>'form-control'
            ),
            'options' => array(
			'empty_option' => 'Select Your Age',
			'value_options' =>  self::$Age_List,
			)
        ));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'blood_group',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'blood_group'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$blood_group,
		)
		));
		
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'gothra_gothram',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'gothra_gothram'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$gothra_nameList,
		)
		));
		$this->add(array(
            'name' => 'gothra_gothram_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'gothra_gothram_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'religion',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'religion'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$religion_nameList,
		)
		));
		$this->add(array(
            'name' => 'religion_other',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control error',
                'id'=>'religion_other'
            ),
            'options' => array(
                'label' => NULL,
            ),
        )); 
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'height',
            'attributes' => array(                
                'id'=>'height',
				'class'=>'form-control'
            ),
            'options' => array(
			'empty_option' => 'Select Your Height',
			'value_options' =>  self::$heightList,
			)
        )); 
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'body_type',
            'attributes' => array(                
                'id'=>'body_type',
				'class'=>'form-control'
            ),
            'options' => array(
			'empty_option' => 'Select Your Body Type',
			'value_options' =>  self::$body_type,
			)
        ));
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'color_complexion',
            'attributes' => array(                
                'id'=>'color_complexion',
				'class'=>'form-control'
            ),
            'options' => array(
			'empty_option' => 'Select Skin Tone',
			'value_options' =>  self::$skin_tone,
			)
        )); 		
		$this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'any_disability',
            'attributes' => array(                
                'id'=>'any_disability',
				'class'=>'form-control'
            ),
            'options' => array(
			'empty_option' => 'Are you Disabled',
			'value_options' =>  self::$disability,
			)
        )); 
		$this->add(array(
            'name' => 'native_place',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'native_place'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));	
		$this->add(array(
            'name' => 'address',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'address'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
            'name' => 'address_line2',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'address_line2'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'country',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'country'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$country_nameList,
		)
		));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'state',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'state'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$state_nameList,
		'disable_inarray_validator' => true,
		)
		));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'city',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'city'
        ),
		'options' => array(
		'empty_option' => 'Select',
		'value_options' =>  self::$city_nameList,
		'disable_inarray_validator' => true,
		)
		));
		$this->add(array(
            'name' => 'zip_pin_code',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'zip_pin_code'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));	
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'id' => 'submit',
                'class' => 'btn btn-default'
            ),
        ));    
        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'reset',
                'value' => 'Cancel',
                'id' => 'cancelButton',
                'class' => 'btn btn-primary'
            ),
        ));
    }

}
?>