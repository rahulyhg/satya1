<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Admin\Model\Entity\States;
use Admin\Form\StateForm;
use Admin\Form\StateFilter;

class StateController extends AppController
{
    protected $data = array();
    
    public function indexAction()
    {   
         $states = $this->getStateTable()->fetchAll($this->data);
        $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
		  StateForm::$country_nameList = $countryNameList;
          $action = $this->getRequest()->getUri()."/searchboxresults";
         StateForm::$actionName = $action;
		$form = new StateForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'states' => $states,'form'=> $form));
    }

    public function AddAction()
    {
        $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));

        StateForm::$country_nameList = $countryNameList;

        // echo"dssd"; die;

        $form = new StateForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $stateEntity = new States();

               $form->setInputFilter(new StateFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $stateEntity->exchangeArray($form->getData());
                // print_r($stateEntity);die;
                $res = $this->getStateTable()->SaveState($stateEntity);

                //      return $this->redirect()->toRoute('admin', array(
                //             'action' => 'index',
                //             'controller' => 'state'
                // ));
//                $response = $this->getResponse();
//            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
//            $response->setContent(json_encode(array("response"=>$res)));
//            return $response;
                return new JsonModel(array("response" => $res));
               }
                else {

                    foreach ($form->getmessages() as $key => $value) {
                        $errors[] = array("element"=>$key,"errors"=>$value['isEmpty']);
                    }
                    return new JsonModel(array("errors" => $errors, "FormId" => $_POST['FormId']));
//            $response = $this->getResponse();
//            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
//            $response->setContent(json_encode(array("errors"=>$errors,"FormId"=>$_POST['FormId'])));
//            return $response;
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editAction()
    {
        $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        
        

        StateForm::$country_nameList = $countryNameList;
//for Testing purpose
        //$action =  "http://localhost/rustagi/admin/state/searchboxresults";
         $action = $this->url()->fromRoute('admin/state', array('action' => 'searchboxresults'));
//for Live Purpose
     //   $action =  "http://rustagisamaj.com/admin/state/searchboxresults";

         StateForm::$actionName = $action;

        $form = new StateForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            $state = $this->getStateTable()->getState($id);
            // print_r($state);die;
            $form->bind($state);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if( !isset($_POST['chkedit']) ){
        if($request->isPost()){

            
            $stateEntity = new States();

               $form->setInputFilter(new StateFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $stateEntity = $form->getData();
                //print_r($stateEntity);die;
                $res = $this->getStateTable()->SaveState($stateEntity);

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
      }
       

        $view = new ViewModel(array('form'=> $form,'id'=>$id));
        $view->setTerminal(true);
        return $view;

    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            // print_r($id);
            $state = $this->getStateTable()->deleteState($id);
            //return $this->redirect()->toRoute('admin', array(
                           // 'action' => 'index',
                          //  'controller' => 'state'
              //  ));
            
            return $this->redirect()->toRoute('admin/state', array('action' => 'index'));
    }
    

    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getStateTable()->getStatejoin($id);

            

        return new ViewModel(array('Info'=> $Info));
    }
    
    public function searchboxresultsAction()
    {
        $value = $_POST['value'];
        $Cid = $_POST['field'];
        if($Cid == 0)
            echo "<p style='color:red'>Please select country</p>";
        else {
           $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
           $sql = "select * from tbl_allstates where (id not in (select master_state_id
            from tbl_state) && state_name like '$value%' && master_country_id=$Cid) ";
           $result=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 

        $view = new ViewModel(array("results"=>$result));
        $view->setTerminal(true);
        return $view;
        }
        exit();    
    }

    public function changestatusAction()
    {   

        $data = (object)$_POST;
        $return = $this->getStateTable()->updatestatus($data);
        // print_r($return);
        return new JsonModel($return);
        exit();

    }

    public function delmultipleAction()
    {
        $ids = $_POST['chkdata'];
        $result = $this->getStateTable()->delmultiple($ids);
        
        echo $result;
        exit();
    }

    public function statuschangeallAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql = "update tbl_state set IsActive=".$_POST['val']." where id IN (".$_POST['ids'].")";
         $results = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 
         if($results)
            echo "updated all";
        else echo "couldn't update"; 
        exit();
    }

    public function ajaxradiosearchAction()
    {
        $status = $_POST['IsActive'];
         $this->data = array("tbl_state.IsActive=$status");

         $results = $this->getStateTable()->fetchAll($this->data);

         $view = new ViewModel(array('results' => $results));
         $view->setTemplate('zfc-admin/state/performsearch');
         $view->setTerminal(true);
         return $view;

    }

    public function countrysearchAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $data = $_POST['value'];
        $countryname = (empty($fieldname = $_POST['fieldname']))?"":" && tbl_state.country_id=".$_POST['fieldname'];

        $result=$adapter->query("select * from tbl_state inner join tbl_country on tbl_state.country_id = tbl_country.id
            where (tbl_state.state_name like '$data%' ".$countryname.")", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 


        $view = new ViewModel(array("Results"=>$result));
        $view->setTerminal(true);
        return $view;
        // print_r($result);
        exit();  
    }

    public function performsearchAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        
         // $field1 = empty($_POST['country_name'])? "": "country_name like '".$_POST['country_name']."%' &&";   
         $field1 = empty($_POST['country_id'])? "": "tbl_state.country_id= '".$_POST['country_id']."' &&";   
         $field2 = empty($_POST['state_name'])? "": " tbl_state.state_name like '".$_POST['state_name']."%' ";   
           
         $sql = "select * from tbl_state inner join tbl_country on tbl_state.country_id = tbl_country.id 
         where ".$field1.$field2."";
         $sql = rtrim($sql,"&&");
        $results = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE); 

         $view = new ViewModel(array("results"=>$results));
        $view->setTerminal(true);
        return $view;
        exit();

    }
}