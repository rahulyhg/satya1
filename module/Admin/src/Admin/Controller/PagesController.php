<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Admin\Model\Entity\AllPages;
use Admin\Form\PagesForm;
use Admin\Form\PagesFilter;

class PagesController extends AppController
{
    
    public function indexAction()
    {   
        if($this->params()->fromRoute('id')==100){
            $message = "Page Added Successfully";
        }
        else if($this->params()->fromRoute('id')==101){
            $message = "Page Edited Successfully";
        }
        else if($this->params()->fromRoute('id')==99){
            $message = "Page Deleted Successfully";
        }
        else $message = "";
// print_r($message);die;


         $pages = $this->getPagesTable()->fetchAll();
         // $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));
		 // $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        // CityForm::$country_nameList = $countryNameList;
        // CityForm::$state_nameList = $stateNameList;
         // print_r($pages);die;
		$form = new PagesForm();
         $form->get('submit')->setAttribute('value', 'Add');
        return new ViewModel(array(
            'AllPages' => $pages,'form'=> $form,'messages'=> $message));
    }


    public function addAction()
    {


        $form = new PagesForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            $page = $this->getPagesTable()->getPage($id);
            // print_r($country);die;
            $form->bind($page);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }
        else $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();


            $pagesEntity = (object)$_POST;

                $res = $this->getPagesTable()->SavePages($pagesEntity);


        // print_r($res);die;

                return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'pages',
                            'id' => 100
                ));


        // return new ViewModel(array('form'=> $form));
        
    }

     public function editAction()
    {


        $form = new PagesForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            $page = $this->getPagesTable()->getPage($id);
            // print_r($country);die;
            $form->bind($page);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }
        else $form->get('submit')->setAttribute('value', 'Add');

         $request = $this->getRequest();
        if($request->isPost()){
         


            $pagesEntity = (object)$_POST;

                $res = $this->getPagesTable()->SavePages($pagesEntity);

                if($res == "success") $mid = 100;
                else $mid = 101; 
        // print_r($res);die;

                return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'pages',
                            'id' => $mid
                ));

        }
        // $view = new ViewModel(array('form'=> $form,'id'=>$id));
        // $view->setTerminal(true);
        // return $view;
        return new ViewModel(array('form'=> $form));
        
    }

     public function changestatusAction()
    {   

        $data = (object)$_POST;
        $return = $this->getPagesTable()->updatestatus($data);
        // print_r($return);
        return new JsonModel($return);
        exit();

    }

    // public function AddAction()
    // {
    //     $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));

    //     CityForm::$state_nameList = $stateNameList;

    //     // echo"dssd"; die;

    //     $form = new CityForm();
    //     $form->get('submit')->setAttribute('value', 'Add');

    //     $request = $this->getRequest();
    //     if($request->isPost()){

    //         $cityEntity = new Cities();

    //            $form->setInputFilter(new CityFilter());
    //            $form->setData($request->getPost());


    //            if($form->isValid()){

    //             $cityEntity->exchangeArray($form->getData());
    //             // print_r($cityEntity);die;
    //             $this->getCityTable()->SaveCity($cityEntity);

    //                  return $this->redirect()->toRoute('admin', array(
    //                         'action' => 'index',
    //                         'controller' => 'pages'
    //             ));
    //            }
    //     }

    //     return new ViewModel(array('form'=> $form));
        
    // }

    // public function editAction($form)
    // {
    //     $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));

    //     CityForm::$state_nameList = $stateNameList;

    //     $form = new CityForm();
    //     if($this->params()->fromRoute('id')>0){
    //         $id = $this->params()->fromRoute('id');
    //         $city = $this->getCityTable()->getCity($id);
    //         // print_r($state);die;
    //         $form->bind($city);
    //         $form->get('submit')->setAttribute('value', 'Edit');
    //         // $this->editAction($form)
    //     }

    //     $request = $this->getRequest();
    //     if($request->isPost()){

    //         $cityEntity = new Cities();

    //            $form->setInputFilter(new CityFilter());
    //            $form->setData($request->getPost());


    //            if($form->isValid()){

    //             $cityEntity = $form->getData();
    //             // print_r($cityEntity);die;
    //             $this->getCityTable()->SaveCity($cityEntity);

    //                  return $this->redirect()->toRoute('admin', array(
    //                         'action' => 'index',
    //                         'controller' => 'pages'
    //             ));
    //            }
    //     }
    //     return new ViewModel(array('form'=> $form/*,'id'=>$id*/));
    // }

   public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getPagesTable()->deletePage($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'pages',
                            'id' => 99
                ));
    }
     /*

    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getCityTable()->getCityjoin($id);

        return new ViewModel(array('Info'=> $Info));
    }
   */
}