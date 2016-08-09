<?php

namespace ZfcAdmin\Controller;

use Zend\View\Model\ViewModel;
use ZfcAdmin\Model\Entity\Gothras;
use ZfcAdmin\Form\GothraForm;
use ZfcAdmin\Form\GothraFilter;

class GothraController extends AppController
{
    
    public function indexAction()
    {   
         $gothras = $this->getGothraTable()->fetchAll();

         // print_r($gothras);die;
		 
		 $form = new GothraForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'gothras' => $gothras,'form'=> $form));
			

       // return new ViewModel(array(
         //   'gothras' => $gothras));
    }

    public function AddAction()
    {
        

        $form = new GothraForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $gothraEntity = new Gothras();

               $form->setInputFilter(new GothraFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $gothraEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getGothraTable()->SaveGothra($gothraEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'index',
                            'controller' => 'gothra'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editAction()
    {
        

        $form = new GothraForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $gothra = $this->getGothraTable()->getGothra($id);
            // print_r($religion);die;
            $form->bind($gothra);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $gothraEntity = new Gothras();

               $form->setInputFilter(new GothraFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $gothraEntity = $form->getData();
                // print_r($cityEntity);die;
                $this->getGothraTable()->SaveGothra($gothraEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'index',
                            'controller' => 'gothra'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getGothraTable()->deleteGothra($id);
            return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'index',
                            'controller' => 'gothra'
                ));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getGothraTable()->getGothra($id);

        return new ViewModel(array('Info'=> $Info));
    }
   
}