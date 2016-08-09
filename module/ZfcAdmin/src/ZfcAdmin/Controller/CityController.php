<?php

namespace ZfcAdmin\Controller;

use Zend\View\Model\ViewModel;
use ZfcAdmin\Model\Entity\Cities;
use ZfcAdmin\Form\CityForm;
use ZfcAdmin\Form\CityFilter;

class CityController extends AppController
{
    
    public function indexAction()
    {   
         $cities = $this->getCityTable()->fetchAll();
         $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));
		 $countryNameList = $this->getCountryTable()->customFields(array('id','country_name'));
        CityForm::$country_nameList = $countryNameList;
        CityForm::$state_nameList = $stateNameList;
		$form = new CityForm();
         $form->get('submit')->setAttribute('value', 'Add');
        return new ViewModel(array(
            'cities' => $cities,'form'=> $form));
    }

    public function AddAction()
    {
        $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));

        CityForm::$state_nameList = $stateNameList;

        // echo"dssd"; die;

        $form = new CityForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $cityEntity = new Cities();

               $form->setInputFilter(new CityFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $cityEntity->exchangeArray($form->getData());
                // print_r($cityEntity);die;
                $this->getCityTable()->SaveCity($cityEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'index',
                            'controller' => 'city'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editAction($form)
    {
        $stateNameList = $this->getStateTable()->customFields(array('id','state_name'));

        CityForm::$state_nameList = $stateNameList;

        $form = new CityForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            $city = $this->getCityTable()->getCity($id);
            // print_r($state);die;
            $form->bind($city);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $cityEntity = new Cities();

               $form->setInputFilter(new CityFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $cityEntity = $form->getData();
                // print_r($cityEntity);die;
                $this->getCityTable()->SaveCity($cityEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'index',
                            'controller' => 'city'
                ));
               }
        }
        return new ViewModel(array('form'=> $form,'id'=>$id));
    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getCityTable()->deleteCity($id);
            return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'index',
                            'controller' => 'city'
                ));
    }
    

    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getCityTable()->getCityjoin($id);

        return new ViewModel(array('Info'=> $Info));
    }
   
}