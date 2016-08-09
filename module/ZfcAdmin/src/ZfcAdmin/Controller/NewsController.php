<?php

namespace ZfcAdmin\Controller;

use Zend\View\Model\ViewModel;
use ZfcAdmin\Model\Entity\Newses;
use ZfcAdmin\Model\Entity\Newscategories;
use ZfcAdmin\Form\NewsForm;
use ZfcAdmin\Form\NewscategoryForm;
use ZfcAdmin\Form\NewsFilter;
use ZfcAdmin\Form\NewscategoryFilter;

class NewsController extends AppController
{
    
    public function indexnewsAction()
    {   
         $newses = $this->getNewsTable()->fetchAll();


        return new ViewModel(array(
            'newses' => $newses));
    }

    public function addnewsAction()
    {
        $categoryNameList = $this->getNewscategoryTable()->customFields(array('id','category_name'));

        NewsForm::$category_nameList = $categoryNameList;

        // print_r($categoryNameList); die;

        $form = new NewsForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

           $mergedata = array_merge(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $newsEntity = new Newses();

               $form->setInputFilter(new NewsFilter());
               $form->setData($mergedata);


               if($form->isValid()){

                $newsEntity->exchangeArray($form->getData());

                $this->getNewsTable()->SaveNews($newsEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'indexnews',
                            'controller' => 'news'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editnewsAction($form)
    {
        $categoryNameList = $this->getNewscategoryTable()->customFields(array('id','category_name'));

        NewsForm::$category_nameList = $categoryNameList;

        $form = new NewsForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            $news = $this->getNewsTable()->getNews($id);
            // print_r($state);die;
            $form->bind($news);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

                $mergedata = array_merge(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $newsEntity = new Newses();

               $form->setInputFilter(new NewsFilter());
               $form->setData($mergedata);


               if($form->isValid()){

                // $newsEntity = $form->getData();
                $newsEntity->exchangeArray($form->getData());
                // print_r($newsEntity);die;
                $this->getNewsTable()->SaveNews($newsEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'indexnews',
                            'controller' => 'news'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));
    }

    public function deletenewsAction()
    {
         
            $id = $this->params()->fromRoute('id');
            // print_r($id);
            $state = $this->getNewsTable()->deleteNews($id);
            return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'indexnews',
                            'controller' => 'news'
                ));
    }
    

    
    public function viewnewsAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getNewsTable()->getNewsjoin($id);

            

        return new ViewModel(array('Info'=> $Info));
    }


    public function indexnewscategoryAction()
    {   
         $newscategories = $this->getNewscategoryTable()->fetchAll();

         // print_r($newsecategories);die;
        return new ViewModel(array(
            'newscategories' => $newscategories));
    }

    public function addnewscategoryAction()
    {
        

        $form = new NewscategoryForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $newscategoryEntity = new Newscategories();

               $form->setInputFilter(new NewscategoryFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $newscategoryEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getNewscategoryTable()->SaveNewscategory($newscategoryEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'indexnewscategory',
                            'controller' => 'news'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editnewscategoryAction($form)
    {
        

        $form = new NewscategoryForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $newscategory = $this->getNewscategoryTable()->getNewscategory($id);
            // print_r($religion);die;
            $form->bind($newscategory);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $newscategoryEntity = new Newscategories();

               $form->setInputFilter(new NewscategoryFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $newscategoryEntity = $form->getData();
                // print_r($newscategoryEntity);die;
                $this->getNewscategoryTable()->SaveNewscategory($newscategoryEntity);

                     return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'indexnewscategory',
                            'controller' => 'news'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }

    public function deletenewscategoryAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getNewscategoryTable()->deleteNewscategory($id);
            return $this->redirect()->toRoute('zfcadmin/admin', array(
                            'action' => 'indexnewscategory',
                            'controller' => 'news'
                ));
    }
    
    public function viewnewscategoryAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getNewscategoryTable()->getNewscategory($id);

        return new ViewModel(array('Info'=> $Info));
    }
   
}