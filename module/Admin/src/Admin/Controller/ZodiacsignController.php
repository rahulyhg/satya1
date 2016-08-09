<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Admin\Model\Entity\Zodiacsigns;
use Admin\Form\ZodiacsignForm;
use Admin\Form\ZodiacsignFilter;

class ZodiacsignController extends AppController
{
    
    public function indexAction()
    {   
         $zodiacsigns = $this->getZodiacsignTable()->fetchAll();
		 
		  $form = new ZodiacsignForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'zodiacsigns' => $zodiacsigns,'form'=> $form));

        //return new ViewModel(array(
           // 'zodiacsigns' => $zodiacsigns));
    }

    // public function AddAction()
    // {
        

    //     $form = new StarsignForm();
    //     $form->get('submit')->setAttribute('value', 'Add');

    //     $request = $this->getRequest();
    //     if($request->isPost()){

    //         $starsignEntity = new Starsigns();

    //            $form->setInputFilter(new StarsignFilter());
    //            $form->setData($request->getPost());


    //            if($form->isValid()){

    //             $starsignEntity->exchangeArray($form->getData());
    //             // print_r($religionEntity);die;
    //             $this->getStarsignTable()->SaveStarsign($starsignEntity);

    //                  return $this->redirect()->toRoute('admin', array(
    //                         'action' => 'index',
    //                         'controller' => 'starsign'
    //             ));
    //            }
    //     }

    //     return new ViewModel(array('form'=> $form));
        
    // }

    public function editAction()
    {
        

        $form = new ZodiacsignForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $zodiacsign = $this->getZodiacsignTable()->getZodiacsign($id);
            // print_r($religion);die;
            $form->bind($zodiacsign);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $zodiacsignEntity = new Zodiacsigns();

               $form->setInputFilter(new ZodiacsignFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $zodiacsignEntity = $form->getData();
                // print_r($cityEntity);die;
                $this->getZodiacsignTable()->SaveZodiacsign($zodiacsignEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'zodiacsign'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }

    public function deleteAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getZodiacsignTable()->deleteZodiacsign($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'index',
                            'controller' => 'zodiacsign'
                ));
    }
    
    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getZodiacsignTable()->getZodiacsign($id);

        return new ViewModel(array('Info'=> $Info));
    }
   
}