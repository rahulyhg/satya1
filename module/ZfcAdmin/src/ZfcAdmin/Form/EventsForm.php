<?php
namespace ZfcAdmin\Form;

use Zend\Form\Form;

class EventsForm extends Form {

    public static $country_nameList = array();
    public static $city_nameList = array();
    public static $state_nameList = array();


    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('Events');
        $this->setAttribute('method', 'post');
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'event_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'event_name'
            ),
            'options' => array(
                'label' => 'Event Title',
            ),
        ));

        $this->add(array(
            'name' => 'sponser_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'sponser_name'
            ),
            'options' => array(
                'label' => 'Sponser Name',
            ),
        ));

         $this->add(array(
            'name' => 'sponser_contact',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control',
                'id'=>'sponser_contact'
            ),
            'options' => array(
                'label' => 'Sponser Contact',
            ),
        ));

        $this->add(array(
            'name' => 'event_organiser',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'event_organiser'
            ),
            'options' => array(
                'label' => 'Organiser Name',
            ),
        ));

        $this->add(array(
            'name' => 'organiser_contact',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control',
                'id'=>'organiser_contact'
            ),
            'options' => array(
                'label' => 'Organiser Contact',
            ),
        ));


        $this->add(array(
            'name' => 'sponser_photo',
            'attributes' => array(
                'type' => 'file',
                'class' => 'thisnot',
                'id'=>'sponser_photo'
            ),
            'options' => array(
                'label' => 'Sponser Photo',
            ),
        ));

        $this->add(array(
            'name' => 'organiser_photo',
            'attributes' => array(
                'type' => 'file',
               'class' => 'thisnot',
                'id'=>'organiser_photo'
            ),
            'options' => array(
                'label' => 'Organiser Photo',
            ),
        ));

        $this->add(array(
        'type' => 'Hidden',
        'name' => 'event_desc',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'event_desc'
        ),
        'options' => array(
            'label' => 'Event Description',
        )
        ));

        $this->add(array(
            'name' => 'image',
            'attributes' => array(
                'type' => 'file',
                 'class' => 'form-control',
                'id'=>'image'
            ),
            'options' => array(
                'label' => 'Upload Event Image',
            ),
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
        'name' => 'city_id',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'city_id'
        ),
        'options' => array(
            'label' => 'City Name',
        'empty_option' => 'Please Select City Name',
        'value_options' =>  self::$city_nameList,
        )
        ));


        $this->add(array(
            'name' => 'venue',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control',
                'id'=>'venue'
            ),
            'options' => array(
                'label' => 'venue',
            ),
        ));

        $this->add(array(
            'name' => 'event_date',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'event_date'
            ),
            'options' => array(
                'label' => 'Start Date',
            ),
        ));

        $this->add(array(
            'name' => 'end_date',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'end_date'
            ),
            'options' => array(
                'label' => 'End Date',
            ),
        ));

        $this->add(array(
            'name' => 'start_time',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control timepicker',
                'id'=>'start_time'
            ),
            'options' => array(
                'label' => 'Start Time',
            ),
        ));

        $this->add(array(
            'name' => 'end_time',
            'attributes' => array(
                'type' => 'time',
                'class' => 'form-control timepicker',
                'id'=>'end_time'
            ),
            'options' => array(
                'label' => 'End Time',
            ),
        ));


        $this->add(array(
            'name' => 'event_cost',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control',
                'id'=>'event_cost'
            ),
            'options' => array(
                'label' => 'Event Cost',
            ),
        ));
        $this->add(array(
            'name' => 'event_members',
            'attributes' => array(
                'type' => 'number',
                'class' => 'form-control',
                'id'=>'event_members'
            ),
            'options' => array(
                'label' => 'Event Members',
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
