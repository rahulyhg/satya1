<?php
namespace Admin\Form;

use Zend\Form\Form;

class NewsForm extends Form {

    public static $category_nameList = array();


    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('tbl_news');
        $this->setAttribute('method', 'post');
        	
		$this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id'=>'title'
            ),
            'options' => array(
                'label' => 'News Title',
            ),
        ));

        $this->add(array(
        'type' => 'Hidden',
        'name' => 'description',
        'attributes' => array(
                'id'=>'description'
        ),
        'options' => array(
            'label' => 'Description',
        )
        ));

        $this->add(array(
            'name' => 'image_path',
            'attributes' => array(
                'type' => 'file',
                 
                'id'=>'image_path'
            ),
            'options' => array(
                'label' => 'Upload Image',
            ),
        ));

        
        $this->add(array(
        'type' => 'Zend\Form\Element\Select',
        'name' => 'news_category_id',
        'attributes' => array(
                'class' => 'form-control',
                'id'=>'news_category_id'
        ),
        'options' => array(
            'label' => 'News Category',
        'empty_option' => 'Please Select Category Name',
        'value_options' =>  self::$category_nameList,
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
