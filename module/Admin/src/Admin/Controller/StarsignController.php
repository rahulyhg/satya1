<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Admin\Model\Entity\Starsigns;
use Admin\Form\StarsignForm;
use Admin\Form\StarsignFilter;

class StarsignController extends AppController
{
    
    public function indexAction()
    {   
         $starsigns = $this->getStarsignTable()->fetchAll();

         // print_r($gothras);die;
		 
		  $form = new StarsignForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'starsigns' => $starsigns,'form'=> $form));

        return new ViewModel(array(
            'starsigns' => $starsigns));
    }

    public function AddAction()
    {
        

        $form = new StarsignForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $starsignEntity = new Starsigns();

               $form->setInputFilter(new StarsignFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $starsignEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getStarsignTable()->SaveStarsign($starsignEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'starsign'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editAction()
    {
        

        $form = new StarsignForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $starsign = $this->getStarsignTable()->getStarsign($id);
            // print_r($religion);die;
            $form->bind($starsign);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $starsignEntity = new Starsigns();

               $form->setInputFilter(new StarsignFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $starsignEntity = $form->getData();
                // print_r($cityEntity);die;
                $this->getStarsignTable()->SaveStarsign($starsignEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'starsign'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getStarsignTable()->deleteStarsign($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'starsign'
                ));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getStarsignTable()->getStarsign($id);

        return new ViewModel(array('Info'=> $Info));
    }
   
}