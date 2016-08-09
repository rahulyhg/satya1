<?php
namespace Application\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;    
use Zend\InputFilter\InputFilter;                
use Zend\InputFilter\InputFilterAwareInterface;  
use Zend\InputFilter\InputFilterInterface;       

class Posts implements InputFilterAwareInterface
{
    public $id;
    public $post_category;
    public $user_id;
	public $title;
    public $image;
    public $language;   
    public $description;   
    public $keywords;   
    public $created_by;   
    public $created_date;   
    public $IsActive;   
    public $modified_date;   
	public $modified_by;   
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
		$this->post_category = (isset($data['post_category'])) ? $data['post_category'] : null; 
  		$this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
		$this->title = (isset($data['title'])) ? $data['title'] : null; 
  		$this->image = (isset($data['image'])) ? $data['image'] : null; 
        $this->language     = (isset($data['language']))     ? $data['language']     : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null; 
        $this->keywords = (isset($data['keywords'])) ? $data['keywords'] : null;
        $this->created_by = (isset($data['created_by'])) ? $data['created_by'] : null; 
        $this->created_date = (isset($data['created_date'])) ? $data['created_date'] : null;
        $this->IsActive     = (isset($data['IsActive']))     ? $data['IsActive']     : null;
        $this->modified_date = (isset($data['modified_date'])) ? $data['modified_date'] : null; 
        $this->modified_by = (isset($data['modified_by'])) ? $data['modified_by'] : null; 
          
        return $this;
    }
    public function getInputFilter()
    {
        //if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'post_category',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ))); 
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'image',
                'required' => true,
                 
            ))); 
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'language',
                'required' => true,
                 
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'description',
                'required' => true,
                 
            ))); 
            
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