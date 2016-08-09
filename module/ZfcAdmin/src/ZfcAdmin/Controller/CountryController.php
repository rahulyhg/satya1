<?php

namespace ZfcAdmin\Controller;

// use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use ZfcAdmin\Model\Entity\Countries;
use ZfcAdmin\Form\CountryForm;
use ZfcAdmin\Form\CountryFilter;

class CountryController extends AppController
{
    protected $data = array();
    
    public function indexAction()
    {   
         $countries = $this->getCountryTable()->fetchAll($this->data);

         $action = $this->getRequest()->getUri()."/searchboxresults";
         CountryForm::$actionName = $action;
         $form = new CountryForm();
         $form->get('submit')->setAttribute('value', 'Add');


        return new ViewModel(array(
            'countries' => $countries,'form'=> $form));
    }

    public function AddAction()
    {


        $form = new CountryForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            $country = $this->getCountryTable()->getCountry($id);
            // print_r($country);die;
            $form->bind($country);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }
        else $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $countryEntity = new Countries();

               $form->setInputFilter(new CountryFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $countryEntity->exchangeArray($form->getData());
                $res = $this->getCountryTable()->SaveCountry($countryEntity);

                $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            $response->setContent(json_encode(array("response"=>$res)));
            return $response;
                 
               }
               else {

                    foreach ($form->getmessages() as $key => $value) {
                        $errors[] = array("element"=>$key,"errors"=>$value['isEmpty']);
                    }

            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            $response->setContent(json_encode(array("errors"=>$errors,"FormId"=>$_POST['FormId'])));
            return $response;
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editAction($form)
    {   
	//for testing purpose
        $action =  "http://localhost/rustagi/admin/country/searchboxresults";
         
	//for Live purpose
       // $action =  "http://localhost/admin/country/searchboxresults";


	CountryForm::$actionName = $action;
        $form = new CountryForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            $country = $this->getCountryTable()->getCountry($id);
            // print_r($country);die;
            $form->bind($country);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if( !isset($_POST['chkedit']) ){
        if($request->isPost()){
             
            $countryEntity = new Countries();

               $form->setInputFilter(new CountryFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $countryEntity = $form->getData();
                // print_r($countryEntity);die;
                $res = $this->getCountryTable()->SaveCountry($countryEntity);

                     $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            $response->setContent(json_encode(array("response"=>$res)));
            return $response;
               }
                else {

                    foreach ($form->getmessages() as $key => $value) {
                        $errors[] = array("element"=>$key,"errors"=>$value['isEmpty']);
                    }

            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
            $response->setContent(json_encode(array("errors",$errors)));
            return $response;
               }
        }
    }
         

        $view = new ViewModel(array('form'=> $form,'id'=>$id));
        $view->setTerminal(true);
        return $view;

    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            // print_r($id);
            $country = $this->getCountryTable()->deleteCountry($id);
            return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'index',
                            'controller' => 'country'
                ));
    }
    

    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getCountryTable()->getCountry($id);

            // echo"<pre>"; print_r($Info);die;

        return new ViewModel(array('Info'=> $Info));
    }

    public function searchboxresultsAction()
    {
        $data = $_POST['value'];
           $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
           $result=$adapter->query("select * from allcountries where (id not in (select master_country_id
            from tbl_country) && country_name like '$data%') ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 

        // $result = $this->getAllCountryTable()->searchresults($data);
        $view = new ViewModel(array("countries"=>$result,"parentname"=>$_POST['field']));
        $view->setTerminal(true);
        return $view;
        exit();    
    }

    public function countrysearchAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];

        $result=$adapter->query("select * from tbl_country where country_name like '$data%' ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 


        $view = new ViewModel(array("Results"=>$result));
        $view->setTerminal(true);
        return $view;
        exit();  
    }

    public function performsearchAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        
         $field1 = empty($_POST['country_name'])? "": "country_name like '".$_POST['country_name']."%' &&";   
         $field2 = empty($_POST['country_code'])? "": "country_code like '".$_POST['country_code']."%' &&";   
         $field3 = empty($_POST['dial_code'])? "": "dial_code like '".$_POST['dial_code']."%' ";   
           
         $sql = "select * from tbl_country where ".$field1.$field2.$field3."";
         $sql = rtrim($sql,"&&");
        $results = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 

         $view = new ViewModel(array("results"=>$results));
        $view->setTerminal(true);
        return $view;


        exit();

    }

    public function ajaxradiosearchAction()
    {
        $status = $_POST['IsActive'];
         $this->data = array("IsActive=$status");

         $results = $this->getCountryTable()->fetchAll($this->data);
        // return new ViewModel(array('countries' => $countries));

         $view = new ViewModel(array('results' => $results));
         $view->setTemplate('zfc-admin/country/performsearch');
         $view->setTerminal(true);
         return $view;

    }

    public function changestatusAction()
    {   

        $data = (object)$_POST;
        $return = $this->getCountryTable()->updatestatus($data);
        // print_r($return);
        return new JsonModel($return);
        exit();

    }

    public function delmultipleAction()
    {
        $ids = $_POST['chkdata'];
        $result = $this->getCountryTable()->delmultiple($ids);
        
        echo $result;
        exit();
    }

    public function statuschangeallAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "update tbl_country set IsActive=".$_POST['val']." where id IN (".$_POST['ids'].")";
         $results = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 
         if($results)
            echo "updated all";
        else echo "couldn't update"; 
        exit();
    }


   
}
