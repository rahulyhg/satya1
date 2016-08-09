<?php
namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;    
use Zend\InputFilter\InputFilter;                
use Zend\InputFilter\InputFilterAwareInterface;  
use Zend\InputFilter\InputFilterInterface;       

class Memberbasic implements InputFilterAwareInterface
{
    public $id;	
	public $profile_for;
	public $profile_for_others;
	public $name_title_user; 
    public $full_name;   
	public $alternate_mobile_no;
	public $phone_no; 
	public $gender;
	public $native_place;    
    public $address;   
	public $address_line2;
	public $country; 
	public $state;
	public $city;    
    public $zip_pin_code;   
	public $dob;
	public $age;
	public $any_disability;    
    public $color_complexion;   
	public $body_type;
	public $height;
	public $blood_group; 
	//public $marital_status;
	public $gothra_gothram;    
    public $gothra_gothram_other;   
	public $religion;
	public $religion_other;
	 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
		$this->profile_for = (isset($data['profile_for'])) ? $data['profile_for'] : null;
		$this->profile_for_others = (isset($data['profile_for_others'])) ? $data['profile_for_others'] : null;
		$this->name_title_user = (isset($data['name_title_user'])) ? $data['name_title_user'] : null;
        $this->full_name = (isset($data['full_name'])) ? $data['full_name'] : null;
        $this->alternate_mobile_no = (isset($data['alternate_mobile_no'])) ? $data['alternate_mobile_no'] : null;
        $this->phone_no = (isset($data['phone_no'])) ? $data['phone_no'] : null;
		$this->gender     = (isset($data['gender']))     ? $data['gender']     : null;		 
  		$this->native_place = (isset($data['native_place'])) ? $data['native_place'] : null;		
  		$this->address = (isset($data['address'])) ? $data['address'] : null;       
		$this->address_line2 = (isset($data['address_line2'])) ? $data['address_line2'] : null;
        $this->country = (isset($data['country'])) ? $data['country'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
        $this->city = (isset($data['city'])) ? $data['city'] : null;
		$this->zip_pin_code     = (isset($data['zip_pin_code']))     ? $data['zip_pin_code']     : null;		 
  		$this->dob = (isset($data['dob'])) ? $data['dob'] : null;
		$this->age = (isset($data['age'])) ? $data['age'] : null;
		$this->any_disability = (isset($data['any_disability'])) ? $data['any_disability'] : null;
		$this->color_complexion     = (isset($data['color_complexion']))     ? $data['color_complexion']     : null;		 
  		$this->body_type = (isset($data['body_type'])) ? $data['body_type'] : null;
		$this->height = (isset($data['height'])) ? $data['height'] : null;
		$this->blood_group = (isset($data['blood_group'])) ? $data['blood_group'] : null;       
		//$this->marital_status = (isset($data['marital_status'])) ? $data['marital_status'] : null;
        $this->gothra_gothram = (isset($data['gothra_gothram'])) ? $data['gothra_gothram'] : null;
		$this->gothra_gothram_other = (isset($data['gothra_gothram_other'])) ? $data['gothra_gothram_other'] : null;        
        $this->religion = (isset($data['religion'])) ? $data['religion'] : null;
		$this->religion_other     = (isset($data['religion_other']))     ? $data['religion_other']     : null;
        return $this;
    }
    public function getInputFilter()
    {
        //if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ))); 
			
			/* $inputFilter->add($factory->createInput(array(
                'name'     => 'full_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            ))); 
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'profile_for',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            )));
			 $inputFilter->add($factory->createInput(array(
                'name'     => 'address',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            )));
			$inputFilter->add($factory->createInput(array(
                'name'     => 'native_place',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            ))); */
            $this->inputFilter = $inputFilter;
        //}

        return $this->inputFilter;
    }
     // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}