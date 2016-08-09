<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Admin\Model\Entity\Religions;
use Admin\Form\ReligionForm;
use Admin\Form\ReligionFilter;

class ReligionController extends AppController
{
    
    public function indexAction()
    {   
         $religions = $this->getReligionTable()->fetchAll();

         // print_r($cities);die;
		 
		   
		$form = new ReligionForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'religions' => $religions,'form'=> $form));
			
    }

    public function AddAction()
    {
        

        $form = new ReligionForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $religionEntity = new Religions();

               $form->setInputFilter(new ReligionFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $religionEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getReligionTable()->SaveReligion($religionEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'religion'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editAction($form)
    {
        

        $form = new ReligionForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $religion = $this->getReligionTable()->getReligion($id);
            // print_r($religion);die;
            $form->bind($religion);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $religionEntity = new Religions();

               $form->setInputFilter(new ReligionFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $religionEntity = $form->getData();
                // print_r($cityEntity);die;
                $this->getReligionTable()->SaveReligion($religionEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'religion'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getReligionTable()->deleteReligion($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'religion'
                ));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getReligionTable()->getReligion($id);

        return new ViewModel(array('Info'=> $Info));
    }
   
}