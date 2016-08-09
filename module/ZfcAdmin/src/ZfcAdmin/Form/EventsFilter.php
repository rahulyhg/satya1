<?php
namespace ZfcAdmin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class EventsFilter extends InputFilter {

    public function __construct() {
        	
		$this->add(array(
            'name' => 'event_name',
            'required'=> true,
        ));
        $this->add(array(
            'name' => 'sponser_name',
            'required'=> true,
        ));
        $this->add(array(
            'name' => 'event_organiser',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'event_desc',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'country_id',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'state_id',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'city_id',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'image',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'event_date',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'end_date',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'start_time',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'end_time',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'event_cost',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'event_members',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'sponser_contact',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'organiser_contact',
            'required'=> true,
        ));

        $this->add(array(
            'name' => 'IsActive',
            'required'=> true,
        ));

    }

}
