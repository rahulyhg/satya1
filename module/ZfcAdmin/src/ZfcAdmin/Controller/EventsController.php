<?php

namespace ZfcAdmin\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use ZfcAdmin\Model\Entity\Events;
use ZfcAdmin\Form\EventsForm;
use ZfcAdmin\Form\EventsFilter;

class EventsController extends AppController
{
    public function eventsindexAction()
    {   
        $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        $cityNameList = $this->getCityTable()->customFields(array('id','city_name'));
        $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));

        EventsForm::$country_nameList = $countryNameList;
        EventsForm::$city_nameList = $cityNameList;
        EventsForm::$state_nameList = $stateNameList;

        // print_r($categoryNameList); die;

        $form = new EventsForm();
        $form->get('submit')->setAttribute('value', 'Add This Event');

         $events = $this->getEventsTable()->fetchAll();

// print_r("dfghdf");die; 

        return new ViewModel(array(
            'events' => $events,'form'=> $form));
    }


    public function eventsaddAction()
    {
        $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        $cityNameList = $this->getCityTable()->customFields(array('id','city_name'));
        $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));

        EventsForm::$country_nameList = $countryNameList;
        EventsForm::$city_nameList = $cityNameList;
        EventsForm::$state_nameList = $stateNameList;

        // print_r($categoryNameList); die;

        $form = new EventsForm();
        $form->get('submit')->setAttribute('value', 'Add This Event');

        $request = $this->getRequest();
        if($request->isPost()){

           $mergedata = array_merge(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
           // echo "fghf";
           // print_r($mergedata);die;
            $eventsEntity = new Events();

               $form->setInputFilter(new EventsFilter());
               $form->setData($mergedata);


               if($form->isValid()){

                $eventsEntity->exchangeArray($form->getData());
                
                $this->getEventsTable()->SaveEvents($eventsEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'eventsindex',
                            'controller' => 'events'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function eventseditAction()
    {
         
        $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        $cityNameList = $this->getCityTable()->customFields(array('id','city_name'));
        $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));

        EventsForm::$country_nameList = $countryNameList;
        EventsForm::$city_nameList = $cityNameList;
        EventsForm::$state_nameList = $stateNameList;
        $form = new EventsForm();
         if(isset($_POST['chkedit'])){
            $id=$_POST['id'];
            $events = $this->getEventsTable()->getEvents($_POST['id']);
            // print_r($state);die;
            $form->bind($events);
         $form->get('submit')->setAttribute('value', 'Edit');

        }
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            $events = $this->getEventsTable()->getEvents($_POST['id']);
            // print_r($state);die;
            $form->bind($events);
            $form->get('submit')->setAttribute('value', 'Save');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if(!isset($_POST['chkedit'])){
        if($request->isPost()){
            // echo "dfsgdsfg";

           $mergedata = array_merge(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            
            $eventsEntity = new Events();

               $form->setInputFilter(new EventsFilter());
               $form->setData($mergedata);


               if($form->isValid()){

                $eventsEntity->exchangeArray($form->getData());
                // print_r($eventsEntity);die;
                
                $this->getEventsTable()->SaveEvents($eventsEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'eventsindex',
                            'controller' => 'events'
                ));
               }
            }
        }

        $view = new ViewModel(array('form'=> $form,'id'=>$id));
        $view->setTerminal(true);
        return $view;
        // echo $_POST['id'];
        // die;
    }

    public function eventsdeleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            // print_r($id);
            $state = $this->getEventsTable()->deleteEvents($id);
            return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'eventsindex',
                            'controller' => 'events'
                ));
    }
    

    
    public function eventsviewAction()
    {
        $id = $_POST['id'];

        $Info = $this->getEventsTable()->getEventsjoin($id);

            

        $view = new ViewModel(array('Info'=> $Info));
        $view->setTerminal(true);
        return $view;
    }

    public function changestatusAction()
    {   

        $data = (object)$_POST;
        $return = $this->getEventsTable()->updatestatus($data);
        // print_r($return);
        return new JsonModel($return);
        exit();

    }


    // public function indexnewscategoryAction()
    // {   
    //      $newscategories = $this->getNewscategoryTable()->fetchAll();

    //      // print_r($newsecategories);die;
    //     return new ViewModel(array(
    //         'newscategories' => $newscategories));
    // }

    // public function addnewscategoryAction()
    // {
        

    //     $form = new NewscategoryForm();
    //     $form->get('submit')->setAttribute('value', 'Add');

    //     $request = $this->getRequest();
    //     if($request->isPost()){

    //         $newscategoryEntity = new Newscategories();

    //            $form->setInputFilter(new NewscategoryFilter());
    //            $form->setData($request->getPost());


    //            if($form->isValid()){

    //             $newscategoryEntity->exchangeArray($form->getData());
    //             // print_r($religionEntity);die;
    //             $this->getNewscategoryTable()->SaveNewscategory($newscategoryEntity);

    //                  return $this->redirect()->toRoute('zfcadmin/admin', array(
    //                         'action' => 'indexnewscategory',
    //                         'controller' => 'news'
    //             ));
    //            }
    //     }

    //     return new ViewModel(array('form'=> $form));
        
    // }

   
    // public function viewnewscategoryAction()
    // {
    //     $id = $this->params()->fromRoute('id');

    //     $Info = $this->getNewscategoryTable()->getNewscategory($id);

    //     return new ViewModel(array('Info'=> $Info));
    // }
   
}