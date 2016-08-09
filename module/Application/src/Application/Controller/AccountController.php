<?php
namespace Application\Controller;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Mail;
use Zend\Mime\Part;
use Zend\Session\Container;
class AccountController extends AppController
{
	protected $data = array();
	public function DashboardAction(){
		   
		return new ViewModel();
	}
	public function LogoutAction(){
        $session = new Container('user');
        $session->getManager()->getStorage()->clear('user');
      return $this->redirect()->toRoute("application/default",array('controller'=>'index','action'=>'index'));		
    }
	public function MemberbasicAction(){

		$button = $_POST['submit'];

      $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');		
        $session = new Container('user');
		$user_id=$session->offsetGet('id');
		$ref_no=$session->offsetGet('ref_no');
		$country_name=$this->getCountryTable()->selectList(array('id', 'country_name'));
		$state_name=$this->getStateTable()->selectList(array('id', 'state_name'));
		$city_name=$this->getCityTable()->selectList(array('id', 'city_name'));
		$height=$this->getHeightTable()->selectList(array('id', 'height'));
		$religion_name=$this->getReligionTable()->selectList(array('id', 'religion_name'));
		$gothra_name=$this->getGothraTable()->selectList(array('id', 'gothra_name'));		
		\Application\Form\MemberbasicForm::$country_nameList=$country_name;	
        \Application\Form\MemberbasicForm::$state_nameList=$state_name;			
		\Application\Form\MemberbasicForm::$city_nameList=$city_name;
		\Application\Form\MemberbasicForm::$heightList=$height;
		\Application\Form\MemberbasicForm::$Age_List=$this->getAge();
		\Application\Form\MemberbasicForm::$Name_Title=$this->GetNameTitle();
		\Application\Form\MemberbasicForm::$gothra_nameList=$gothra_name;
		\Application\Form\MemberbasicForm::$religion_nameList=$religion_name;		
		\Application\Form\MemberbasicForm::$blood_group=$this->BloodGroup();
		\Application\Form\MemberbasicForm::$marital_status=$this->MeritalStatus();
		$udata = $this->getUserInfoTable()->GetUserDetail($user_id);       
        $MemberbasicForm = new \Application\Form\MemberbasicForm();
        $MemberbasicForm->bind($udata);
		$request=$this->getRequest();

		$data_gallery=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
			if($request->isPost()){			
			$page = new \Application\Model\Entity\Memberbasic();
			$MemberbasicForm->setInputFilter($page->getInputFilter());
			$MemberbasicForm->setData($request->getPost());
			$data = (array) $request->getPost();
			if ($MemberbasicForm->isValid()) {
				$page->exchangeArray($data);				
				unset($page->inputFilter);				 
                $page->dob= date('Y-m-d',strtotime($page->dob));				
				$id=$this->getUserInfoTable()->saveUserData($page);
				// if($id>0){
				
			 //   }
				if($button == "Save") 
				{
        			return $this->redirect()->toRoute('application/default', array(
							'action' => 'memberbasic',
							'controller' => 'account'
				));
				} 
				if($button == "Save & Next") {
					$this->redirect()->toRoute("application/default",array(
					"action" => "editeducation",
					"controller" => "account",
					));
				}

			}           			
		}
		
		$pro_per = $this->ProfileBar();
			 
        return new ViewModel(array("form"=>$MemberbasicForm,"gallery_data"=>$data_gallery,"percent"=>$pro_per));
      	
    }
	 
	public function editeducationAction(){

		$button = $_POST['submit'];


		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$session = new Container('user');
		$user_id=$session->offsetGet('id');
		$ref_no=$session->offsetGet('ref_no');
		$education_level=$this->getEducationLevelTable()->selectList(array('id', 'education_level'));	
		\Application\Form\EducationForm::$educationList=$education_level;
		$education_field=$this->getEducationFieldTable()->selectList(array('id', 'education_field'));	
		\Application\Form\EducationForm::$education_fieldList=$education_field;
		\Application\Form\EducationForm::$Employment_status=$this->EmploymentStatus();
		$professionList=$this->getProfessionTable()->selectList(array('id', 'profession'));	
		\Application\Form\EducationForm::$professionTypeList=$professionList;
		$udata = $this->getUserInfoTable()->GetUserEducation($session->offsetGet('id'));		
		$EducationForm = new \Application\Form\EducationForm();
		$EducationForm->bind($udata);
		$request=$this->getRequest();
			if($request->isPost()){
			$page = new \Application\Model\Entity\Education();
			$EducationForm->setInputFilter($page->getInputFilter());
			$EducationForm->setData($request->getPost());
			$data = (array) $request->getPost();			
			if ($EducationForm->isValid()) {				
				$page->exchangeArray($data);				
				unset($page->inputFilter);				
				$id=$this->getUserInfoTable()->saveUserEducation($page);
				// if($id>0){
				// return $this->redirect()->toRoute('application/default', array(
				// 			'action' => 'editeducation',
				// 			'controller' => 'account'
				// ));
			 //   }

			   if($button == "Save") 
				{
        			return $this->redirect()->toRoute('application/default', array(
							'action' => 'editeducation',
							'controller' => 'account'
				));
				} 
				if($button == "Save & Next") {
					$this->redirect()->toRoute("application/default",array(
					"action" => "editcareer",
					"controller" => "account",
					));
				}

			}          			
		}
		$data_gallery=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
		 
		$pro_per = $this->ProfileBar();

		 return new ViewModel(array("form"=>$EducationForm,"gallery_data"=>$data_gallery,"percent"=>$pro_per));
		
	}
	public function editcareerAction(){

			$button = $_POST['submit'];
			 						

		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$session = new Container('user');
		$user_id=$session->offsetGet('id');
		$ref_no=$session->offsetGet('ref_no');
		$city_name=$this->getCityTable()->selectList(array('id', 'city_name'));	
		$state_name=$this->getStateTable()->selectList(array('id', 'state_name'));	
		$country_name=$this->getCountryTable()->selectList(array('id', 'country_name'));
		$designation=$this->getDesignationTable()->selectList(array('id', 'designation'));	
		\Application\Form\CareerForm::$country_nameList=$country_name;
		\Application\Form\CareerForm::$state_nameList=$state_name;
		\Application\Form\CareerForm::$city_nameList=$city_name;
		\Application\Form\CareerForm::$designationList=$designation;
		\Application\Form\CareerForm::$workingWith=$this->WorkingWithCompany();
		$annual_income=$this->getAnnualIncomeTable()->selectList(array('id', 'annual_income'));	
		\Application\Form\CareerForm::$annual_incomeList=$annual_income;		
		$udata = $this->getUserInfoTable()->GetUserCareer($session->offsetGet('id'));
		$CareerForm = new \Application\Form\CareerForm();
		$CareerForm->bind($udata);			
		$request=$this->getRequest();
			if($request->isPost()){            				
			$page = new \Application\Model\Entity\Career();
			$CareerForm->setInputFilter($page->getInputFilter());
			$CareerForm->setData($request->getPost());			
			$data = (array) $request->getPost();
			//if($CareerForm->isValid()) {					/
				$page->exchangeArray($data);				
				unset($page->inputFilter);					
				$id=$this->getUserInfoTable()->saveUserCareer($page);
				// if($id>0){
				// return $this->redirect()->toRoute('application/default', array(
				// 			'action' => 'editcareer',
				// 			'controller' => 'account'
				// ));
			 //   }

			   if($button == "Save") 
				{
        			return $this->redirect()->toRoute('application/default', array(
							'action' => 'editcareer',
							'controller' => 'account'
				));
				} 
				if($button == "Save & Next") {
					$this->redirect()->toRoute("application/default",array(
					"action" => "editfamily",
					"controller" => "account",
					));
				}
			//}          			
		}
		$data_gallery=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
		
		$pro_per = $this->ProfileBar();

		return new ViewModel(array("form"=>$CareerForm,"gallery_data"=>$data_gallery,"percent"=>$pro_per));		
	}
	public function editfamilyAction(){	

			$button = $_POST['submit'];

	$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
	$session = new Container('user');
			$user_id=$session->offsetGet('id');
		   $ref_no=$session->offsetGet('ref_no');
	$M_status =	$adapter->query("select marital_status from tbl_user_info where user_id='".$user_id."'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
	$M_status =  (empty($M_status[0]['marital_status']))? "":$M_status[0]['marital_status'];

			
		\Application\Form\FamilyInfoForm::$Employment_status=$this->LiveStatus();
		\Application\Form\FamilyInfoForm::$Family_Values=$this->FamilyValuesStatus();
		\Application\Form\FamilyInfoForm::$Name_Title=$this->GetNameTitle();
		$udata = $this->getFamilyInfoTable()->getFamilyInfo($session->offsetGet('id'));
		// print_r($udata->mother_photo);die;
		$FamilyInfoForm = new \Application\Form\FamilyInfoForm();
		//$FamilyInfoForm->get('user_id')->setValue($session->offsetGet('id'));
		$FamilyInfoForm->bind($udata);		
		$request=$this->getRequest();		
			if($request->isPost()){				
			$page = new \Application\Model\Entity\Family();
			$FamilyInfoForm->setInputFilter($page->getInputFilter());
			$FamilyInfoForm->setData($request->getPost());			
			$data = (array) $request->getPost();			
			// if($FamilyInfoForm->isValid()) {
				$mar_status = (empty($_POST['marital_status']))? "":$_POST['marital_status'];
				$marstatus = $adapter->query("update tbl_user_info set marital_status='".$mar_status."' where user_id='".$user_id."'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
				$M_status = ($marstatus==false)? "":$mar_status;

				$page->exchangeArray($data);				
				unset($page->inputFilter);
				$page->user_id=$session->offsetGet('id');
				$page->spouse_dob= date('Y-m-d',strtotime($page->spouse_dob));
				$page->spouse_died_on= date('Y-m-d',strtotime($page->spouse_died_on));
				$page->father_dob= date('Y-m-d',strtotime($page->father_dob));
				$page->father_dod= date('Y-m-d',strtotime($page->father_dod));
				$page->mother_dob= date('Y-m-d',strtotime($page->mother_dob));
				$page->mother_dod= date('Y-m-d',strtotime($page->mother_dod));				
				$page->grand_father_dob= date('Y-m-d',strtotime($page->grand_father_dob));
				$page->grand_father_dod= date('Y-m-d',strtotime($page->grand_father_dod));
				$page->grand_mother_dob= date('Y-m-d',strtotime($page->grand_mother_dob));
				$page->grand_mother_dod= date('Y-m-d',strtotime($page->grand_mother_dod));
				$page->g_grand_father_dob= date('Y-m-d',strtotime($page->g_grand_father_dob));
				$page->g_grand_father_dod= date('Y-m-d',strtotime($page->g_grand_father_dod));				
				$page->g_grand_mother_dob= date('Y-m-d',strtotime($page->g_grand_mother_dob));
				$page->g_grand_mother_dod= date('Y-m-d',strtotime($page->g_grand_mother_dod));
				$page->spouse_fatherDOB= date('Y-m-d',strtotime($page->spouse_fatherDOB));
				$page->spouse_fatherDiedOn= date('Y-m-d',strtotime($page->spouse_fatherDiedOn));				
				$page->spouse_motherDOB= date('Y-m-d',strtotime($page->spouse_motherDOB));
				$page->spouse_motherDiedOn= date('Y-m-d',strtotime($page->spouse_motherDiedOn));

				$page->brother_dob= date('Y-m-d',strtotime($page->brother_dob));
				$page->sister_dob= date('Y-m-d',strtotime($page->sister_dob));
				$page->S_sister_dob= date('Y-m-d',strtotime($page->S_sister_dob));
				$page->kids_dob= date('Y-m-d',strtotime($page->kids_dob));


				$page->name_title_kids= (empty($page->name_title_kids))? null:serialize($page->name_title_kids);
				$page->kids_name= (empty($page->kids_name))? null:serialize($page->kids_name);
				$page->kids_status= (empty($page->kids_status))? null:serialize($page->kids_status);
				$page->kids_dob= (empty($page->kids_dob))? null:serialize($_POST['kids_dob']);


				$page->name_title_brother= (empty($page->name_title_brother))? null:serialize($page->name_title_brother);
				$page->brother_name= (empty($page->brother_name))? null:serialize($page->brother_name);
				$page->brother_status= (empty($page->brother_status))? null:serialize($page->brother_status);
				$page->brother_dob= (empty($page->brother_dob))? null:serialize($_POST['brother_dob']);

				$page->name_title_sister= (empty($page->name_title_sister))? null:serialize($page->name_title_sister);
				$page->sister_name= (empty($page->sister_name))? null:serialize($page->sister_name);
				$page->sister_status= (empty($page->sister_status))? null:serialize($page->sister_status);
				$page->sister_dob= (empty($page->sister_dob))? null:serialize($_POST['sister_dob']);

				$page->name_title_S_sister= (empty($page->name_title_S_sister))? null:serialize($page->name_title_S_sister);
				$page->S_sister_name= (empty($page->S_sister_name))? null:serialize($page->S_sister_name);
				$page->S_sister_status= (empty($page->S_sister_status))? null:serialize($page->S_sister_status);
				$page->S_sister_dob= (empty($page->S_sister_dob))? null:serialize($_POST['S_sister_dob']);
			 	 
				$id=$this->getFamilyInfoTable()->savefamilyInfoOld($page);
				 
			   if($button == "Save") 
				{
        			return $this->redirect()->toRoute('application/default', array(
							'action' => 'editfamily',
							'controller' => 'account'
				));
				} 
				if($button == "Save & Next") {
					$this->redirect()->toRoute("application/default",array(
					"action" => "post",
					"controller" => "account",
					));
				}
			// }          			
		}	
		$data_gallery=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
		
		$pro_per = $this->ProfileBar();


		 return new ViewModel(array("form"=>$FamilyInfoForm,"gallery_data"=>$data_gallery,"family_data"=>$udata,'M_status'=>$M_status,"percent"=>$pro_per));
		 
	}
	public function editmatrimoniAction(){
		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$session = new Container('user');
		$user_id=$session->offsetGet('id');
		$ref_no=$session->offsetGet('ref_no');
		$religion_name=$this->getReligionTable()->selectList(array('id', 'religion_name'));
		$gothra_name=$this->getGothraTable()->selectList(array('id', 'gothra_name'));
		\Application\Form\MetrimoniForm::$gothra_nameList=$gothra_name;
		\Application\Form\MetrimoniForm::$religion_nameList=$religion_name;		
		\Application\Form\MetrimoniForm::$blood_group=$this->BloodGroup();
		\Application\Form\MetrimoniForm::$marital_status=$this->MeritalStatus();		
		$MetrimoniForm = new \Application\Form\MetrimoniForm();
		$udata = $this->getUserInfoTable()->GetUserMatrimoni($session->offsetGet('id'));
		$MetrimoniForm = new \Application\Form\MetrimoniForm();
		$id=$udata->id;
		$MetrimoniForm->bind($udata);
		$request=$this->getRequest();
			if($request->isPost()){
			$page = new \Application\Model\Entity\Matrimoni();
			$MetrimoniForm->setInputFilter($page->getInputFilter());
			$MetrimoniForm->setData($request->getPost());			
			$data = (array) $request->getPost();             		
			if ($MetrimoniForm->isValid()) {				
				$page->exchangeArray($data);				
				unset($page->inputFilter);
				$page->id=$id;
				$page->user_id=$session->offsetGet('id');
				$id=$this->getUserInfoTable()->saveUserMatrimoni($page);
				if($id>0){
				return $this->redirect()->toRoute('application/default', array(
							'action' => 'editmatrimoni',
							'controller' => 'account'
				));
			   }
			}         			
		}
		$data_gallery=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
		 
		$pro_per = $this->ProfileBar();


		 return new ViewModel(array("form"=>$MetrimoniForm,"gallery_data"=>$data_gallery));
		
	}
	
	public function editaboutAction(){
		$button = $_POST['about_meSave'];

		

			$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		       $session = new Container('user');
			   $user_id=$session->offsetGet('id');
			   $ref_no=$session->offsetGet('ref_no');
		 $request=$this->getRequest();
		if($request->isPost()){	
			  $text= $request->getPost("about_Yourself");			  			   
			   $adapter->query("UPDATE tbl_user_info set`about_yourself_partner_family`='$text' where user_id='$user_id' AND ref_no='$ref_no'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);			
		} 
			$data=$adapter->query("select `about_yourself_partner_family` as about_me from tbl_user_info where user_id='$user_id' AND ref_no='$ref_no'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
			$data_gallery=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
		
		if($button == "Save") 
			{
				return new ViewModel(array("my_info"=>$data,"gallery_data"=>$data_gallery));

			} 
		if($button == "Save & Next") {
			$this->redirect()->toRoute("application/default",array(
				"action" => "memberbasic",
				"controller" => "account",
				));
		}

		$pro_per = $this->ProfileBar();

				return new ViewModel(array("my_info"=>$data,"gallery_data"=>$data_gallery,"percent"=>$pro_per));


	}

	public function mygalleryAction(){
		// $F_fields = array("mother_photo",)
		


		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$session = new Container('user');
			   $user_id=$session->offsetGet('id');
			   $ref_no=$session->offsetGet('ref_no');
		$data=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC limit 6", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
		
		$metadata = new \Zend\Db\Metadata\Metadata($adapter);
		$table = $metadata->getTable("tbl_family_info");
		$table->getColumns();

		foreach ($table->getColumns() as $column) {
        		if(strpos($column->getName(),"photo")){
        			$columns[] = $column->getName();
        		}
    	}	
    		// foreach ($columns as $key => $value) {
				$Fdata=$adapter->query("select * from tbl_family_info where user_id='$user_id' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
    		// }
				foreach ($Fdata as $F_data) {
					foreach ($columns as $key => $value) {
						if(empty($F_data->$value)) continue;
						else $Fphotos[] = $F_data->$value;
					}
    		}

    		foreach ($data as $P_data) {
					foreach ($P_data as $key => $value) {
							 
							if($key == "image_path")
								$Pphotos[] = $value;
					}
    		}

    		shuffle($Fphotos);
    		shuffle($Pphotos);
    		$data_gallery=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
    	
		$pro_per = $this->ProfileBar();
    		
		return new ViewModel(array("Pphotos"=>$Pphotos,"F_photos"=>$Fphotos,"gallery_data"=>$data_gallery,"percent"=>$pro_per));
	}

	public function showallimagesAction()
	{
		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$session = new Container('user');
			   $user_id=$session->offsetGet('id');
			   $ref_no=$session->offsetGet('ref_no');

		if($_POST['type'] == "Personal"){
			$data=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
			foreach ($data as $P_data) {
					foreach ($P_data as $key => $value) {
							 
							if($key == "image_path")
								$photos[] = array($value,$P_data['id']);
					}
    		}

//for testing purpose
//    		$action = $server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/account/delselected";
//for live purpose
$action = $server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/account/delselected";
		
		$output[] = "<input class='btn btn-default' type='button' style='float:right;' onclick='delselected(&quot;showallimages&quot;,&quot;$action&quot;,delselectedresults)' value='delete selected'><br><br>";

		foreach ($photos as $key => $value) {
			$title = (!(int)$value[1])?ucwords(str_replace("_"," ",$value[1])):"";
			$output[] = 

//for testing purpose
			/*'<div class="col-sm-3"><img src="/rustagi/'.$value[0].'" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>




    <div class="deleteimg"> 
    	<input type="checkbox" name="delimages&#91;&#93;" value="'.$value[1].'" />
    	<input type="hidden" name="id_field" value="'.$value[1].'" />
    </div>
    <div class="familytitles">'.$title.'</div>
    </div>';*/

//for live purpose

'<div class="col-sm-3"><img src="/'.$value[0].'" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>




    <div class="deleteimg"> 
    	<input type="checkbox" name="delimages&#91;&#93;" value="'.$value[1].'" />
    	<input type="hidden" name="id_field" value="'.$value[1].'" />
    </div>
    <div class="familytitles">'.$title.'</div>
    </div>';



		}
		$output[] = "<input type='hidden' name='type' value='".$_POST['type']."'><input type='hidden' name='uid' value='".$user_id."'>";
		// echo join("",$output);

		}
		else {


			$metadata = new \Zend\Db\Metadata\Metadata($adapter);
		$table = $metadata->getTable("tbl_family_info");
		$table->getColumns();

		foreach ($table->getColumns() as $column) {
        		if(strpos($column->getName(),"photo") || strpos($column->getName(),"_name")){
        			$columns[] = $column->getName();
        		}
    	}	
    		// foreach ($columns as $key => $value) {
				$Fdata=$adapter->query("select * from tbl_family_info where user_id='$user_id' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
    		// }
				foreach ($Fdata as $F_data) {
					foreach ($columns as $key => $value) {
						if(strpos($value,"photo")){
							if(empty($F_data->$value)) continue;
							else $photos[] = array(array($F_data->$value,$value),array($F_data->$columns[$key-1],$columns[$key-1]));
						}
					}
    		}
//for testing purpose
//    		$action = $server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/rustagi/account/delselected";
//for live purpose
$action = $server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost()."/account/delselected";
		
		$output[] = "<input class='btn btn-default' type='button' style='float:right;' onclick='delselected(&quot;showallimages&quot;,&quot;$action&quot;,delselectedresults)' value='delete selected'><br><br>";

		foreach ($photos as $key => $value) {
			$title = (!(int)$value[0][1])?ucwords(str_replace("_"," ",$value[0][1])):"";
			$Name = (!(int)$value[1][0])?ucwords(str_replace("_"," ",$value[1][0])):"";
			$output[] = 
//for testing purpose
/*
'<div class="col-sm-3"><img src="/rustagi/'.$value[0][0].'" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>
    <div class="deleteimg"> 
    	<input type="checkbox" name="delimages&#91;&#93;" value="'.$value[0][1].'" />
    	<input type="hidden" name="id_field" value="'.$value[0][1].'" />
    </div>
    <div class="familytitles">'.$title.'</div>
    <div class="familytitles">'.$Name.'</div>
    </div>';
		*/
//for Live Purpose
'<div class="col-sm-3"><img src="/'.$value[0][0].'" onmouseover="showchck(this)" onmouseout="hidechck(this)" onclick="selectchk(this)" class="moreimgthambdeleat imghover"/>
    <div class="deleteimg"> 
    	<input type="checkbox" name="delimages&#91;&#93;" value="'.$value[0][1].'" />
    	<input type="hidden" name="id_field" value="'.$value[0][1].'" />
    </div>
    <div class="familytitles">'.$title.'</div>
    <div class="familytitles">'.$Name.'</div>
    </div>';


}


		$output[] = "<input type='hidden' name='type' value='".$_POST['type']."'><input type='hidden' name='uid' value='".$user_id."'>";

		}
		 
		echo join("",$output);
		// echo "<pre>";
		// print_r($photos);
		die;
	}

	public function delselectedAction()
	{	
		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

		if($_POST['Itype']=="Personal"){
			$sql = "delete from tbl_user_gallery where id IN(".$_POST['idfield'].")";
		}
		else {
			$var = str_replace(",", "='',",$_POST['idfield']);
			$var = "".$var."=''";
			$sql = "update tbl_family_info set $var where user_id='".$_POST['user_id']."'";
		}

				$result =$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

				echo ($result)? "deleted Successfully":"Couldn't perform your request";
		// echo $sql;
		die;
	}

	public function AjaxImgUploadAction(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {             
            $name     = $_FILES['img_file']['name'];
            $tmpName  = $_FILES['img_file']['tmp_name'];
            $error    = $_FILES['img_file']['error'];
            $size     = $_FILES['img_file']['size'];
            $ext      = strtolower(pathinfo($name, PATHINFO_EXTENSION));           
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if ( !in_array($ext, array('jpg','jpeg','png','gif')) ) {
                        $valid = false;
                        $response = "Invalid file extension. Only( jpg, jpeg, png, gif ) are allowed";
                    }
                    //validate file size
                    if ( $size/1024/1024 > 2 ) {
                        $valid = false;
                        $response = "File size is exceeding 2MB maximum allowed size.";						
                    }
                    //upload file
                    if ($valid) {
						$bashPath=ROOT_PATH;
						$session = new Container('user');
			            $user_id=$session->offsetGet('id');
						$ref_no=$session->offsetGet('ref_no');
						$user_name=$session->offsetGet('full_name');
						$user_folder=$user_id."__".$user_name;
						$name=   time().$name;
					  if (!file_exists($bashPath."/uploads/$user_folder")) {
							mkdir($bashPath."/uploads/$user_folder", 0777, true);
							$targetPath =  $bashPath."/uploads/$user_folder/".$name;
                            $uploaded=move_uploaded_file($tmpName,$targetPath);
						}
						else{
							$targetPath =  $bashPath."/uploads/$user_folder/".$name;
                            $uploaded=move_uploaded_file($tmpName,$targetPath);
						}
						if($uploaded){
							$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
						 $QUERY="UPDATE tbl_user_info set profile_photo='/uploads/$user_folder/$name' WHERE `user_id`='$user_id' AND `ref_no`='$ref_no'";
						 $user=$adapter->query($QUERY, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
						 //*****Insert in Gallery Table******
						 $adapter->query("insert into tbl_user_gallery set user_id='$user_id',ref_no='$ref_no',image_path='/uploads/$user_folder/$name',
						 img_relation='user'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
						 $session->profile_photo="/uploads/$user_folder/$name";
							 $response = 'File uploaded Successfully.';
							return new JsonModel(array("Status"=>"true","message"=>$response,"file_path"=>"/uploads/$user_folder/$name"));							
						}else{
							 $response = "Error! File Couldn't uploaded";							
						}                        
                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $response = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $response = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $response = 'Missing a temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $response = 'Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $response = 'File upload stopped by extension.';
                    break;
                default:
                    $response = 'Unknown error';
                break;
            } 
            return new JsonModel(array("Status"=>"false","message"=>$response));
        } 
	}	
	public function AjaxImgUploadGalleryAction(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			if($_POST['cropenabled'] != "Enable"){
			// if($_POST['img_relation'] !='' && $_FILES['file_upload']['name'] !=''){
				$img_relation=trim($_POST['img_relation']);
				$name     = $_FILES['file_upload']['name'];
            $tmpName  = $_FILES['file_upload']['tmp_name'];
            $error    = $_FILES['file_upload']['error'];
            $size     = $_FILES['file_upload']['size'];
            $ext      = strtolower(pathinfo($name, PATHINFO_EXTENSION));           
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if ( !in_array($ext, array('jpg','jpeg')) ) {
                        $valid = false;
                        $response = "Invalid file extension. Only( jpg, jpeg ) are allowed";
                    }
                    //validate file size
                    if ( $size/1024/1024 > 2 ) {
                        $valid = false;
                        $response = "File size is exceeding 2MB maximum allowed size.";						
                    }
                    //upload file
                    if ($valid) {
						$bashPath=ROOT_PATH;
						$session = new Container('user');
			            $user_id=$session->offsetGet('id');
						$ref_no=$session->offsetGet('ref_no');
						$user_name=$session->offsetGet('full_name');
						$user_folder=$user_id."__".$user_name;
						$name=   time().$name;
					  if (!file_exists($bashPath."/uploads/$user_folder")) {
							mkdir($bashPath."/uploads/$user_folder", 0777, true);
							$targetPath =  $bashPath."/uploads/$user_folder/".$name;
                            $uploaded=move_uploaded_file($tmpName,$targetPath);
						}
						else{
							$targetPath =  $bashPath."/uploads/$user_folder/".$name;
                            $uploaded=move_uploaded_file($tmpName,$targetPath);
						}
						if($uploaded){
							$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
							 //*********Insert in Gallery Table******
							 $adapter->query("insert into tbl_user_gallery set user_id='$user_id',ref_no='$ref_no',image_path='/uploads/$user_folder/$name',
							 img_relation='user'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
							 //*********Select Images to Render******
							 $data=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
							 $response = 'File uploaded Successfully.';
							return new JsonModel(array("Status"=>"true","message"=>$response,"gallery_data"=>$data));							
						}else{
							 $response = "Error! File Couldn't uploaded";							
						}                        
                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $response = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $response = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $response = 'Missing a temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $response = 'Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $response = 'File upload stopped by extension.';
                    break;
                default:
                    $response = 'Unknown error';
                break;
              } 
		 //  }else{
			// $response = 'All fields are required!';
		 //  }            
            return new JsonModel(array("Status"=>"false","message"=>$response));
        	}
        	else {
        		$session = new Container('user');
			            $user_id=$session->offsetGet('id');
						$ref_no=$session->offsetGet('ref_no');

						// $ref_no=$session->offsetGet('ref_no');
						$user_name=$session->offsetGet('full_name');
						$name=   time().$_FILES['file_upload']['name'];
	$ext      = strtolower(pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION));

$original_image = $_FILES['file_upload']['tmp_name'];

$user_folder=$user_id."__".$user_name."/";

$new_image = ROOT_PATH.'/uploads/'.$user_folder.$name;

$image_quality = '95';



if (!file_exists(ROOT_PATH."/uploads/$user_folder")) {
							mkdir(ROOT_PATH."/uploads/$user_folder", 0777, true);
							// $targetPath =  ROOT_PATH.'/uploads/'.$user_folder.$name;
                            // $uploaded=move_uploaded_file($tmpName,$targetPath);
						}
						 
// Get dimensions of the original image
list( $current_width, $current_height ) = getimagesize( $original_image );

// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
$x1 = $_POST['x1'];
$y1 = $_POST['y1'];
$x2 = $_POST['x2'];
$y2 = $_POST['y2'];
$width = $_POST['width'];
$height = $_POST['height'];     
// print_r( $_POST ); die;

// Define the final size of the image here ( cropped image )
$crop_width = 200;
$crop_height = 200;
// Create our small image
$new = imagecreatetruecolor( $crop_width, $crop_height );
// Create original image
$current_image = imagecreatefromjpeg( $original_image );
// resampling ( actual cropping )
imagecopyresampled( $new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height );
// this method is used to create our new image
$result = imagejpeg( $new, $new_image, $image_quality );
 
if ( !in_array($ext, array('jpg','jpeg')) ) {
                        return new JsonModel(array("Status"=>0,"message"=>"only jpeg files are allowed"));
                    }

			if($result){
							$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
							 //*********Insert in Gallery Table******
							 $adapter->query("insert into tbl_user_gallery set user_id='$user_id',ref_no='$ref_no',image_path='/uploads/$user_folder/$name',
							 img_relation='user'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
							 //*********Select Images to Render******
							 $data=$adapter->query("select * from tbl_user_gallery where user_id='$user_id' AND ref_no='$ref_no' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
							 $response = 'File uploaded Successfully.';
							return new JsonModel(array("Status"=>"true","message"=>$response,"gallery_data"=>$data));							
						}else{
							 $response = "Error! File Couldn't uploaded";							
						}
        	}
        } 
	}
	public function ChangeProfImgFrGalleryAction(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			 if($_POST["ImageName"] !='')
			 {
				 $ImageName=$_POST["ImageName"];				
				$session = new Container('user');
				$user_id=$session->offsetGet('id');
				$ref_no=$session->offsetGet('ref_no');				
					$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
				 $QUERY="UPDATE tbl_user_info set profile_photo='$ImageName' WHERE `user_id`='$user_id' AND `ref_no`='$ref_no'";
				 $user=$adapter->query($QUERY, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);						 
				 $session->profile_photo="$ImageName";
					 $response = 'Profile updated Successfully.';
				 return new JsonModel(array("Status"=>"true","message"=>$response,"file_path"=>"$ImageName"));
			}else{
				$response = 'No Image was selected!';
			}
        }else{
			$response = 'An-authorize way to upload image!';
		}		
		return new JsonModel(array("Status"=>"false","message"=>$response));
	}
	
	public function postAction(){
		

		$postcategories = $this->getPostcategoryTable()->customFields(array('id','category_name'));
		\Application\Form\PostForm::$postcategoryList=$postcategories;

		// print_r($postcategories);die;

		$postform = new \Application\Form\PostForm();

		$postform = new \Application\Form\PostForm();
    	$request=$this->getRequest();
		if($request->isPost())
		{				
			$page = new \Application\Model\Entity\Posts();
			$postform->setInputFilter($page->getInputFilter());

			$mergedata = array_merge(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
         		// print_r($mergedata);die;

			$postform->setData($mergedata);
			// $data = (array) $request->getPost();
			if ($postform->isValid()) {	
				$entity = $page->exchangeArray($postform->getData());
				 unset($page->inputFilter);
				 
				  // $session = new Container('user');
				  // $user_id=$session->offsetGet('id');
     	// 		echo $user_id;
				 $this->getPostTable()->savePost($entity);				
				return $this->redirect()->toRoute('application/default', array(
							'action' => 'index',
							'controller' => 'Posts',
                            "id" => 1
				));
			}  
		}	

        
		return new ViewModel(array("form"=>$postform,"message"=>$msg));
	}
	/******Ajax Call******/
	public function getStateNameAction(){
		$Request=$this->getRequest();
		if ($Request->isPost()) {
			$Country_ID=$Request->getPost("Country_ID");
			$state_name=$this->getStateTable()->getStateListByCountryCode($Country_ID);
			if(count($state_name))
				return new JsonModel(array("Status"=>"Success","statelist"=>$state_name));
			else
				return new JsonModel(array("Status"=>"Failed","statelist"=>NULL));
		}
	}
	/******Ajax Call******/
	public function getCityNameAction(){
		$Request=$this->getRequest();
		if ($Request->isPost()) {
			$State_ID=$Request->getPost("State_ID");
			$city_name=$this->getCityTable()->getCityListByStateCode($State_ID);
			if(count($city_name))
				return new JsonModel(array("Status"=>"Success","statelist"=>$city_name));
			else
				return new JsonModel(array("Status"=>"Failed","statelist"=>NULL));
		}
	}

	public function cropimageAction()
	{
		 
 
		if($_POST['cropenabled'] == "Enable"){

			$session = new Container('user');
			            $user_id=$session->offsetGet('id');
						// $ref_no=$session->offsetGet('ref_no');
						$user_name=$session->offsetGet('full_name');
						$name=   time().$_FILES['file']['name'];
$original_image = $_FILES['file']['tmp_name'];
	
	// $ext = pathinfo($original_image,PATHINFO_EXTENSION);
	$ext      = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

	if($_POST['field_name'] == "profile_photo") 
		$disablefamily = "/";
	else 
		$disablefamily = "/familyimages/";

$user_folder=$user_id."__".$user_name.$disablefamily;

$new_image = ROOT_PATH.'/uploads/'.$user_folder.$name;

$image_quality = '95';

if (!file_exists(ROOT_PATH."/uploads/$user_folder")) {
							mkdir(ROOT_PATH."/uploads/$user_folder", 0777, true);
							// $targetPath =  ROOT_PATH.'/uploads/'.$user_folder.$name;
                            // $uploaded=move_uploaded_file($tmpName,$targetPath);
						}
						 
// Get dimensions of the original image
list( $current_width, $current_height ) = getimagesize( $original_image );

// Get coordinates x and y on the original image from where we
// will start cropping the image, the data is taken from the hidden fields of form.
$x1 = $_POST['x1'];
$y1 = $_POST['y1'];
$x2 = $_POST['x2'];
$y2 = $_POST['y2'];
$width = $_POST['width'];
$height = $_POST['height'];     
// print_r( $_POST ); die;

// Define the final size of the image here ( cropped image )
$crop_width = 200;
$crop_height = 200;
// Create our small image
$new = imagecreatetruecolor( $crop_width, $crop_height );
// Create original image
$current_image = imagecreatefromjpeg( $original_image );
// resampling ( actual cropping )
imagecopyresampled( $new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $width, $height );
// this method is used to create our new image
$result = imagejpeg( $new, $new_image, $image_quality );
 

	 
		if ( !in_array($ext, array('jpg','jpeg')) ) {
                        return new JsonModel(array("Status"=>0,"message"=>"only jpeg files are allowed"));
                    }

 if($result){

 		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
							 //*********Insert in Gallery Table******
 				// $already = $adapter->query("select user_id from tbl_family_info where user_id=$user_id",\Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();
 				// 	if($already == 0){
 				// 		$adapter->query("insert into ".$_POST['table_name']."('user_id','".$_POST['field_name']."') values($user_id,'/uploads/$user_folder/$name')", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
 				// 	}	
						// else 
						 $adapter->query("update ".$_POST['table_name']." set ".$_POST['field_name']."='/uploads/$user_folder/$name' where user_id=$user_id ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
							 //*********Select Images to Render******
							 // $data=$adapter->query("select ".$_POST['field_name']." from tbl_family_info where user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
								if($_POST['field_name']=="profile_photo"){
									$session = new Container('user');
									$prophoto ='/uploads/'.$user_folder."/".$name;
									$session->profile_photo = $prophoto;
								} 

							 $response = 'File uploaded Successfully.';
							//for testing purpose
							 $imgidpath = "/rustagi/uploads/$user_folder/$name";
							
							//for Live Purpose
							// $imgidpath = "/uploads/$user_folder/$name";
							 
				return new JsonModel(array("Status"=>1,"data"=>$imgidpath,"imgid"=>$_POST['field_name']));
 }
 		else {
				return new JsonModel(array("Status"=>0,"message"=>"couldn't crop image some error occured"));
			}   
}

 else {
 	$response = $this->familyimages($_POST,$_FILES);
 	return $response;
 }

 exit; 

		 
	}


	public function covertdateageAction()
	{	
		$response = $this->getResponse();
            $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );

            $today = date("Y-m-d");
            $dob = $this->convertdate($_POST['value']);

            $years = $this->valdateselection(strtotime($today),strtotime($dob));

            if($years < '15'){
            	$msg = "your age should be greater than 15";
            	$respArr = array("status"=>0,"content"=>$msg);
            }
            else $respArr = array("status"=>1,"content"=>$years);


		$response->setContent(json_encode($respArr));
                return $response;

		 
	}


	public function convertdate($date){

            $timestamp = strtotime($date);
            $date = date("Y-m-d",$timestamp);
            return $date;
    }
    public function valdateselection($today,$dob)
    {
         $diff = $today-$dob;
                $years = floor($diff / (365*60*60*24));
                // $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                // $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                return $years;
    }

}
?>
