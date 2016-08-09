<?php
namespace Application\Form;

use Zend\Form\Form;

class SignupForm extends Form {
	public static $country_nameList=array();
	public static $name_TitleList=array();
	public static $userTypeList=array();
	public static $gothraGothramList=array();
    public static $professionTypeList=array();
	public static $chkduplicateurl="";

	//public static $rustagi_branchList=array(); 
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('form');
        $this->setAttribute('method', 'post');
		$this->setAttribute('id', 'signUpForm');
        $this->setAttribute('class', 'custom_error');
		
		$this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
		
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'user_type_id',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'user_type_id'
        ),
		'options' => array(
		'empty_option' => 'Please Select UserType',
		'value_options' =>  self::$userTypeList,
		)
		));		
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'name_title_user',
		'attributes' => array(
                'class' => 'form-control fomrtitlen tileF',
                'id'=>'name_title_user'
        ),
		'options' => array(		
		'value_options' =>  self::$name_TitleList,
		)
		));
		
		  $this->add(array(
            'name' => 'full_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control fomrnamen',
                'id'=>'full_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'name_title_father',
		'attributes' => array(
                'class' => 'form-control fomrtitlen tileF',
                'id'=>'name_title_father'
        ),
		'options' => array(		
		'value_options' =>  self::$name_TitleList,
		)
		));
		$this->add(array(
            'name' => 'father_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control fomrnamen',
                'id'=>'father_name'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'gender',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'gender'
        ),
		'options' => array(
		'empty_option' => 'Please Select Your Gender',
		'value_options'=> array(
							'Male' =>  'Male',
							'Female' =>  'Female'
		),
		
		)
		));
		
		$this->add(array(
            'type' => 'text',
            'name' => 'address',
            'attributes' => array(                
                'id'=>'address',
				'class'=>'form-control'
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
		'empty_option' => 'Select Country',
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
		'empty_option' => 'Select State',
		//'value_options' =>  self::$state_nameList,
		'disable_inarray_validator' => true
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
		'empty_option' => 'Select City',
		//'value_options' =>  self::$city_nameList,
		'disable_inarray_validator' => true
		)
		));
		
		$this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'rustagi_branch',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'rustagi_branch'
        ),
		'options' => array(
		'empty_option' => 'Select Branch',
		//'value_options' =>  self::$rustagi_branchList,
		'disable_inarray_validator' => true
		)
		));
		
		$this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
                'onkeyup' => 'chkduplicate($(this).val(),this.id,"'.self::$chkduplicateurl.'",chkduplicateresults);',
                'class' => 'form-control',
                'id'=>'username'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		
		$this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control',
                'id'=>'password'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		
		$this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'onkeyup' => 'chkduplicate($(this).val(),this.id,"'.self::$chkduplicateurl.'",chkduplicateresults);',
                'class' => 'form-control',
                'id'=>'email'
            ),
            'options' => array(
                'label' => NULL,
            ),
        ));
		
		$this->add(array(
            'name' => 'mobile_no',
            'attributes' => array(
                'type' => 'number',
                'onkeyup' => 'chkduplicate($(this).val(),this.id,"'.self::$chkduplicateurl.'",chkduplicateresults);',
                'class' => 'form-control error',
                'id'=>'mobile_no'
            ),
            'options' => array(
                'label' => NULL,
            ),
        )); 
		
		  $this->add(array(
		'type' => 'Zend\Form\Element\Select',
		'name' => 'profession',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'profession'
        ),
		'options' => array(
		'empty_option' => 'Please Select Profession',
		'value_options' =>  self::$professionTypeList,
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
		'type' => 'Zend\Form\Element\Select',
		'name' => 'gothra_gothram',
		'attributes' => array(
                'class' => 'form-control',
                'id'=>'gothra_gothram'
        ),
		'options' => array(
		'empty_option' => 'Please Select Gothra',
		'value_options' =>  self::$gothraGothramList,
		)
		));  

        $this->add(array(
        'type' => 'text',
        'name' => 'gothra_gothram_other',
        'attributes' => array(
                 
                'id'=>'gothra_gothram_other',
        'placeholder' => 'Please Specify Others',

        ),
         
        )); 

         $this->add(array(
        'type' => 'text',
        'name' => 'profession_other',
        'attributes' => array(
                 
                'id'=>'profession_other',
        'placeholder' => 'Please Specify Others',

        ),
         
        )); 

          $this->add(array(
        'type' => 'text',
        'name' => 'rustagi_branch_other',
        'attributes' => array(
                 
                'id'=>'rustagi_branch_other',
        'placeholder' => 'Please Specify Others',

        ),
        
        )); 
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Signup',
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