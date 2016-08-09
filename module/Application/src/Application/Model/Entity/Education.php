<?php
namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;    
use Zend\InputFilter\InputFilter;                
use Zend\InputFilter\InputFilterAwareInterface;  
use Zend\InputFilter\InputFilterInterface;       

class Education implements InputFilterAwareInterface
{
    public $id;	
	public $education_level;
	public $education_level_other;
	public $education_field;
	public $education_field_other;    
    public $specialization_major;
	public $employment_status;
	public $employment_status_other;
	public $profession;
	public $profession_other;
	 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
  		$this->education_level = (isset($data['education_level'])) ? $data['education_level'] : null;
		$this->education_level_other = (isset($data['education_level_other'])) ? $data['education_level_other'] : null;	
  		$this->education_field = (isset($data['education_field'])) ? $data['education_field'] : null;   
		$this->education_field_other = (isset($data['education_field_other'])) ? $data['education_field_other'] : null;	
		$this->specialization_major = (isset($data['specialization_major'])) ? $data['specialization_major'] : null;
		$this->employment_status = (isset($data['employment_status'])) ? $data['employment_status'] : null; 
		$this->employment_status_other = (isset($data['employment_status_other'])) ? $data['employment_status_other'] : null;	
		$this->profession = (isset($data['profession'])) ? $data['profession'] : null; 
		$this->profession_other = (isset($data['profession_other'])) ? $data['profession_other'] : null;	
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
                'name'     => 'education_level',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            ))); 
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'education_field',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            )));			
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'specialization_major',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            )));
			$inputFilter->add($factory->createInput(array(
                'name'     => 'profession',
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