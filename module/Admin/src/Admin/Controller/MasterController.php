<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Admin\Model\Entity\Educationfields;
use Admin\Model\Entity\Educationlevels;
use Admin\Model\Entity\Professions;
use Admin\Model\Entity\Designations;
use Admin\Model\Entity\Usertypes;
use Admin\Form\EducationfieldForm;
use Admin\Form\EducationlevelForm;
use Admin\Form\ProfessionForm;
use Admin\Form\DesignationForm;
use Admin\Form\UsertypeForm;
use Admin\Form\EducationfieldFilter;
use Admin\Form\EducationlevelFilter;
use Admin\Form\ProfessionFilter;
use Admin\Form\DesignationFilter;
use Admin\Form\UsertypeFilter;

class MasterController extends AppController
{
    public function masterviewAction()
    {
        // echo "fsdgsd";die;
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        $masterarray1 = array('country'=>'tbl_country','state'=>'tbl_state','city'=>'tbl_city',
            'post'=>'tbl_post','gothra'=>'tbl_gothra_gothram','religion'=>'tbl_religion',
            'starsign'=>'tbl_star_sign','zodiacsign'=>'tbl_zodiac_sign_raasi');

        $masterarray2 = array('Education Fields'=> array('edufield','tbl_education_field'),
            'Education Levels'=> array('edulevel','tbl_education_level'),'Professions'=> array('profession','tbl_profession'),
            'Designations'=> array('designation','tbl_designation'),'User Types'=> array('usertype','tbl_user_type'));

        foreach ($masterarray1 as $key => $value) {

            $query = "select * from ".$value."";

            $counts = $adapter->query($query, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();
            // $url = $this->url("admin",array("controller"=>$key,"action"=>"index"));
            $countarray[$key] = $counts;
        }

        foreach ($masterarray2 as $key => $value) {

            $query = "select * from ".$value[1]."";

            $counts = $adapter->query($query, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();
            // $url = $this->url("admin",array("controller"=>$key,"action"=>"index"));
            $countarray1[$key] = array($value[0],$counts);
        }

        // $masterarray3 = array("Matrimony Users")

        $generalusercount = $this->getUserTable()->getusers(array('user_type_id=1'));
        $generaluserpending = $this->getUserTable()->getusers(array('user_type_id=1 && IsActive=0'));
        $matrimonyusercount = $this->getUserTable()->getusers(array('user_type_id=2'));
        $matrimonyuserpending = $this->getUserTable()->getusers(array('user_type_id=2 && IsActive=0'));
		
		$total=$generalusercount+$matrimonyusercount;
		
        $members = array("General User"=>array($generalusercount,$generaluserpending,'memberuser'),
            "Matrimony User"=>array($matrimonyusercount,$matrimonyuserpending,'matrimonyuser'));

        // echo "<pre>";
        // print_r($generalusercount);die;

        return new ViewModel(array("fieldcounts"=>$countarray,"fieldcounts1"=>$countarray1,"Members"=>$members,"total_members"=>$total));
    }

    public function indexedufieldAction()
    {   
         $educationfields = $this->getEducationfieldTable()->fetchAll();
		 
		 
		  $form = new EducationfieldForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'educationfields' => $educationfields,'form'=> $form));

      //  return new ViewModel(array(
            //'educationfields' => $educationfields));
    }


 public function indexexecutivepostAction()
    {   
        
        return new ViewModel(array('indexexecutivepost'));

      //  return new ViewModel(array(
            //'educationfields' => $educationfields));
    }

    public function addedufieldAction()
    {
        

        $form = new EducationfieldForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $educationfieldEntity = new Educationfields();

               $form->setInputFilter(new EducationfieldFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $educationfieldEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getEducationfieldTable()->SaveEducationfield($educationfieldEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedufield',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }

    public function editedufieldAction()
    {
        

        $form = new EducationfieldForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $educationfield = $this->getEducationfieldTable()->getEducationfield($id);
            // print_r($religion);die;
            $form->bind($educationfield);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $educationfieldEntity = new Educationfields();

               $form->setInputFilter(new EducationfieldFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $educationfieldEntity = $form->getData();
                // print_r($cityEntity);die;
                $this->getEducationfieldTable()->SaveEducationfield($educationfieldEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedufield',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }

    public function deleteedufieldAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getEducationfieldTable()->deleteEducationfield($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedufield',
                            'controller' => 'master'
                ));
    }
    
    public function viewedufieldAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getEducationfieldTable()->getEducationfield($id);

        return new ViewModel(array('Info'=> $Info));
    }



    public function indexedulevelAction()
    {   
         $educationlevels = $this->getEducationlevelTable()->fetchAll();
		 
		   $form = new EducationlevelForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'educationlevels' => $educationlevels,'form'=> $form));
		 
		 

       // return new ViewModel(array(
          //  'educationlevels' => $educationlevels));
    }


    public function addedulevelAction()
    {
        

        $form = new EducationlevelForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $educationlevelEntity = new Educationlevels();

               $form->setInputFilter(new EducationlevelFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $educationlevelEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getEducationlevelTable()->SaveEducationlevel($educationlevelEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedulevel',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }



    public function editedulevelAction()
    {
        

        $form = new EducationlevelForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $educationlevel = $this->getEducationlevelTable()->getEducationlevel($id);
            // print_r($religion);die;
            $form->bind($educationlevel);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $educationlevelEntity = new Educationlevels();

               $form->setInputFilter(new EducationlevelFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $educationlevelEntity = $form->getData();
                // print_r($cityEntity);die;
                $this->getEducationlevelTable()->SaveEducationlevel($educationlevelEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedulevel',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }


    public function deleteedulevelAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getEducationlevelTable()->deleteEducationlevel($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexedulevel',
                            'controller' => 'master'
                ));
    }
    
    public function viewedulevelAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getEducationlevelTable()->getEducationlevel($id);

        return new ViewModel(array('Info'=> $Info));
    }


    public function indexprofessionAction()
    {   
         $professions = $this->getProfessionTable()->fetchAll();
		 
		  $form = new ProfessionForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'professions' => $professions,'form'=> $form));

       // return new ViewModel(array(
         //   'professions' => $professions));
    }


    public function addprofessionAction()
    {
        
        // echo"sdsd";die;
        $form = new ProfessionForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $professionEntity = new Professions();

               $form->setInputFilter(new ProfessionFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $professionEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getProfessionTable()->SaveProfession($professionEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexprofession',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }



    public function editprofessionAction()
    {
        

        $form = new ProfessionForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $profession = $this->getProfessionTable()->getProfession($id);
            // print_r($religion);die;
            $form->bind($profession);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $professionEntity = new Professions();

               $form->setInputFilter(new ProfessionFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $professionEntity = $form->getData();
                
                $this->getProfessionTable()->SaveProfession($professionEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexprofession',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }


    public function deleteprofessionAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getProfessionTable()->deleteProfession($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexprofession',
                            'controller' => 'master'
                ));
    }
    
    public function viewprofessionAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getProfessionTable()->getProfession($id);

        return new ViewModel(array('Info'=> $Info));
    }



    public function indexdesignationAction()
    {   
         $designations = $this->getDesignationTable()->fetchAll();
		 
		  $form = new DesignationForm();
         $form->get('submit')->setAttribute('value', 'Add');

        return new ViewModel(array(
            'designations' => $designations,'form'=> $form));

        //return new ViewModel(array(
          //  'designations' => $designations));
    }


    public function adddesignationAction()
    {
        
        // echo"sdsd";die;
        $form = new DesignationForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $designationEntity = new Designations();

               $form->setInputFilter(new DesignationFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $designationEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getDesignationTable()->SaveDesignation($designationEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexdesignation',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }



    public function editdesignationAction()
    {
        

        $form = new DesignationForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $designation = $this->getDesignationTable()->getDesignation($id);
            // print_r($religion);die;
            $form->bind($designation);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $designationEntity = new Designations();

               $form->setInputFilter(new DesignationFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $designationEntity = $form->getData();
                
                $this->getDesignationTable()->SaveDesignation($designationEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexdesignation',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }


    public function deletedesignationAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getDesignationTable()->deleteDesignation($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexdesignation',
                            'controller' => 'master'
                ));
    }
    
    public function viewdesignationAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getDesignationTable()->getDesignation($id);

        return new ViewModel(array('Info'=> $Info));
    }



    public function indexusertypeAction()
    {   
         $usertypes = $this->getUsertypeTable()->fetchAll();

        return new ViewModel(array(
            'usertypes' => $usertypes));
    }


    public function addusertypeAction()
    {
        
        // echo"sdsd";die;
        $form = new UsertypeForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if($request->isPost()){

            $usertypeEntity = new Usertypes();

               $form->setInputFilter(new UsertypeFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $usertypeEntity->exchangeArray($form->getData());
                // print_r($religionEntity);die;
                $this->getUsertypeTable()->SaveUsertype($usertypeEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexusertype',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form));
        
    }



    public function editusertypeAction()
    {
        

        $form = new UsertypeForm();
        if($this->params()->fromRoute('id')>0){
            $id = $this->params()->fromRoute('id');
            // echo   $id;die;
            $usertype = $this->getUsertypeTable()->getUsertype($id);
            // print_r($religion);die;
            $form->bind($usertype);
            $form->get('submit')->setAttribute('value', 'Edit');
            // $this->editAction($form)
        }

        $request = $this->getRequest();
        if($request->isPost()){

            $usertypeEntity = new Usertypes();

               $form->setInputFilter(new UsertypeFilter());
               $form->setData($request->getPost());


               if($form->isValid()){

                $usertypeEntity = $form->getData();
                
                $this->getUsertypeTable()->SaveUsertype($usertypeEntity);

                     return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexusertype',
                            'controller' => 'master'
                ));
               }
        }

        return new ViewModel(array('form'=> $form,'id'=>$id));

    }


    public function deleteusertypeAction()
    {
         
            $id = $this->params()->fromRoute('id');
            $state = $this->getUsertypeTable()->deleteUsertype($id);
            return $this->redirect()->toRoute('admin', array(
                            'action' => 'indexusertype',
                            'controller' => 'master'
                ));
    }
    
    public function viewusertypeAction()
    {
        $id = $this->params()->fromRoute('id');

        $Info = $this->getUsertypeTable()->getUsertype($id);

        return new ViewModel(array('Info'=> $Info));
    }

    public function addcommAction()
    {
        $id = $this->params()->fromRoute('id');

       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
     

         $communities=$adapter->query("select * from tbl_communities where parent_id = $id", 
         \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

         // foreach ($communities as $comm) {

         //    echo $comm->category_name;

         // }
         $backlinks = $this->backdirectories($id);
         // print_r($backlinks);die;


        return new ViewModel(array("id"=>$id,"Comm"=>$communities,"links"=>$backlinks));


    }

     public function addnewcommAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
     

        $adapter->query("INSERT INTO `tbl_communities`(`category_name`, `parent_id`, `status`)
         VALUES ('".$_POST['newdir']."','".$_POST['parent_id']."',1)",\Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);


        return $this->redirect()->toRoute('admin', array(
                            'action' => 'addcomm',
                            'controller' => 'master',
                            'id' => $_POST['parent_id']
                ));

        // print_r($_POST);
        // exit();

    }

    public function backdirectories($currid='')
{   
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

    $i=$currid;
    // print_r($currid);die;
    while($i>0){

        $row =  $adapter->query("select * from tbl_communities where id=".$i."",\Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
            // print_r($row[0]['parent_id']);die;
           //for testing purpose
            $links[]= '<a href="/rustagi/admin/master/addcomm/'.$row[0]['id'].'">'.$row[0]['category_name'].'</a> > ';
           
           //for Live Purpose
	   // $links[]= '<a href="/admin/master/addcomm/'.$row[0]['id'].'">'.$row[0]['category_name'].'</a> > ';

        $i = $row[0]['parent_id']; 
        unset($row[0]);
    } 
    return join("",array_reverse($links));
}

   
}
