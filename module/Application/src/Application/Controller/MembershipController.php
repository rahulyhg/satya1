<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

class MembershipController extends AppController
{	
	public function indexAction()
    {
       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		/******Fetch all Members Data from db*********/				
		 $GroomData=$adapter->query("select tbl_user_info.user_id as uid,tbl_city.city_name, tbl_rustagi_branches.branch_name, tbl_user.id,tbl_user_info.profile_photo,tbl_user_info.name_title_user,tbl_user_info.full_name,tbl_user_info.age,tbl_user_info.height,tbl_user_info.city,tbl_user_info.address,tbl_user_info.about_yourself_partner_family,tbl_family_info.name_title_father,tbl_family_info.father_name,tbl_profession.profession from tbl_user 
		 INNER JOIN tbl_user_info on tbl_user_info.user_id=tbl_user.id
		 INNER JOIN tbl_family_info on tbl_user.id=tbl_family_info.user_id
         INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
			inner join tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id 
			inner join tbl_rustagi_branches on tbl_user_info.branch_ids=tbl_rustagi_branches.branch_id 
			inner join tbl_city on tbl_user_info.city=tbl_city.id 

		 where tbl_user_roles.IsMember='1'  ORDER BY tbl_user.id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      /******Return to View Model*********/
      	$filters_data = $this->sidebarFilters();
      	// echo"<pre>";
      	// print_r($filters_data);

      	// $records = array();
			// foreach ($GroomData as $result)
			// {
			// 	$records[] = $result;
			// }

			// foreach ($records as $userinfo)
			// {
			// 	echo $userinfo->id;
			// }

    //   	foreach($filters_data["country"] as $k => $v){
    //   		// foreach ($v as $key => $value) {
    //   			print_r($k);
    // //   			foreach ($v["country"] as $result)
				// // {
				// // 	$records[] = $result;
				// // }
    // //   			break;
    //   		// }
    //   	}	
   //    		foreach ($records as $userinfo)
			// {
			// 	echo $userinfo->id;
			// }

     //    foreach($filters_data["country"]["filter_query"] as $k){
  			// // print_r($v);
  			// 	foreach($k["country"] as $p){
  			// 		// print_r($val->id);
  			// 		echo $p->id;
  			// 	}
  			// // echo $v["country"];    		
     //  	}

        return new ViewModel(array("GroomData"=>$GroomData,"filters_data"=>$filters_data));
    }
	
	public function profileViewAction()
    {
        $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		 $user_id=intval($this->params()->fromQuery('groom_id'));
		  $commanData=array();
		  $commanData["officecountry"]='';
		  $commanData["officestate"]='';
		  $commanData["officecity"]='';
		 if($user_id!=''){
			 
		/******Fetch User Data*********/				
		 $UserData=$adapter->query("select tbl_user.email,tbl_user.mobile_no,tbl_user_info.*,tbl_family_info.*,tbl_height.*,
		 tbl_profession.profession,tbl_city.city_name as city,tbl_state.state_name as state,tbl_country.country_name as country,
		 tbl_education_field.education_field,tbl_education_level.education_level,tbl_religion.religion_name as religion,tbl_gothra_gothram.gothra_name as caste,tbl_designation.designation,tbl_annual_income.annual_income FROM tbl_user
		INNER JOIN tbl_user_info on tbl_user.id=tbl_user_info.user_id
		INNER JOIN tbl_family_info on tbl_user.id=tbl_family_info.user_id
		INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
		LEFT JOIN tbl_city on tbl_user_info.city=tbl_city.id
		left join tbl_height on tbl_user_info.height=tbl_height.id
		LEFT JOIN tbl_state on tbl_user_info.state=tbl_state.id
		LEFT JOIN tbl_country on tbl_user_info.country=tbl_country.id
		LEFT JOIN tbl_education_field on tbl_user_info.education_field=tbl_education_field.id
		LEFT JOIN tbl_education_level on tbl_user_info.education_level=tbl_education_level.id
		LEFT JOIN tbl_religion on tbl_user_info.religion=tbl_religion.id
		LEFT JOIN tbl_gothra_gothram on tbl_user_info.gothra_gothram=tbl_gothra_gothram.id
		LEFT JOIN tbl_designation on tbl_user_info.designation=tbl_designation.id
		LEFT JOIN tbl_annual_income on tbl_user_info.annual_income=tbl_annual_income.id
		WHERE tbl_user.id='$user_id' AND tbl_user_info.user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
		 $records = array();
			foreach ($UserData as $result)
			{
				$records[] = $result;
			}
		 foreach($records as $userinfo){
			$office_country=$userinfo->office_country;
			$office_state=$userinfo->office_state;
			$office_city=$userinfo->office_city;			
			if($office_country !=''){
				$countryName=$this->getOfficialData('tbl_country',$office_country,'country_name');
				$commanData["officecountry"]=$countryName;
			   }
			if($office_state !=''){
				$stateName=$this->getOfficialData('tbl_state',$office_state,'state_name');
				$commanData["officestate"]=$stateName;
			   }
			if($office_city !=''){
				$cityName=$this->getOfficialData('tbl_city',$office_city,'city_name');
				$commanData["officecity"]=$cityName;
			  }
		    }

		    $kids_title = unserialize($records[0]['name_title_kids']);
		    $kids_name = unserialize($records[0]['kids_name']);
		    $kids_status = unserialize($records[0]['kids_status']);
		    $kids_dob = unserialize($records[0]['kids_dob']);

		    $kids_info = array($kids_title,$kids_name,$kids_status,$kids_dob);

		    $records[0]['kids_info'] = $kids_info;


		    $brother_title = unserialize($records[0]['name_title_brother']);
		    $brother_name = unserialize($records[0]['brother_name']);
		    $brother_status = unserialize($records[0]['brother_status']);
		    $brother_dob = unserialize($records[0]['brother_dob']);

		    $brother_info = array($brother_title,$brother_name,$brother_status,$brother_dob);

		    $records[0]['brother_info'] = $brother_info;



		   $sister_title = unserialize($records[0]['name_title_sister']);
		    $sister_name = unserialize($records[0]['sister_name']);
		    $sister_status = unserialize($records[0]['sister_status']);
		    $sister_dob = unserialize($records[0]['sister_dob']);

		    $sister_info = array($sister_title,$sister_name,$sister_status,$sister_dob);

		    $records[0]['sister_info'] = $sister_info;

			// echo "<pre>";
			//  print_r($records);
		 // 	die;

		 }
        else{
			$UserData=array();
		}

		 $galleries = $this->galleries($user_id);
		

		$filters_data = $this->sidebarFilters();

        return new ViewModel(array("userinfo"=>$records,"officeData"=>$commanData,"filters_data"=>$filters_data,"galleries"=>$galleries));
    }
	public function communityMembersAction(){
		
		return new ViewModel();
	}

	public function filtersAction()
	{
		// echo $_POST['value']."----".$_POST['type'];

		if(isset($_POST['range_filter'])){

			// print_r($_POST);
			$value = explode("-",$_POST['value']);
			// print_r($value);

			$where = "where tbl_user_roles.IsMember='1' and tui.".$_POST['type']." BETWEEN ".$value[0]." AND ".$value[1].""; 
		}
		else if($_POST['type']=="full_name"){

			$where = "where tbl_user_roles.IsMember='1' and tui.".$_POST['type']." LIKE '".$_POST['value']."%'"; 

		}
		else { $where = "where tbl_user_roles.IsMember='1' and tui.".$_POST['type']."='".$_POST['value']."'";
			 }

			 if($_POST['type']=="country"){

			 	$state_name=$this->getStateTable()->getStateListByCountryCode($_POST['value']);

			 	$output[] = "<option>---Select---state---</option>";
         
          			foreach($state_name as $states)
            			{
               				 $output[] = "<option value=".$states['id'].">".$states['state_name']."</option>";
            			}
         
      				$output[] = "</select>";
      				echo "<div id='CSCresults' ftyle='state' style='display:none;'>".join("",$output)."</div>";
			 }

			 if($_POST['type']=="state"){

			 	$city_name=$this->getCityTable()->getCityListByStateCode($_POST['value']);

			 	$output[] = "<option>---Select---city---</option>";
         
          			foreach($city_name as $cities)
            			{
               				 $output[] = "<option value=".$cities['id'].">".$cities['city_name']."</option>";
            			}
         
      				$output[] = "</select>";
      				echo "<div id='CSCresults' ftyle='city' style='display:none;'>".join("",$output)."</div>";
			 }

			 $sql = "select tui.*,tui.user_id as uid,tbl_rustagi_branches.branch_name,tbl_family_info.father_name,tbl_user_roles.*,tbl_religion.religion_name,tbl_profession.profession,tbl_education_field.education_field,tbl_city.city_name,tbl_height.height,tbl_state.state_name,tbl_country.country_name,tbl_education_level.education_level from tbl_user_info as tui 
			inner join tbl_profession on tui.profession=tbl_profession.id 
			left join tbl_religion on tui.religion=tbl_religion.id 
			left join tbl_education_field on tui.education_field=tbl_education_field.id 
			left join tbl_city on tui.city=tbl_city.id 
			left join tbl_state on tui.state=tbl_state.id 
			left join tbl_country on tui.country=tbl_country.id 
			left join tbl_height on tui.height=tbl_height.id 
			left JOIN tbl_education_level on tui.education_level=tbl_education_level.id
			inner join tbl_user_roles on tui.user_id=tbl_user_roles.user_id 
			inner join tbl_rustagi_branches on tui.branch_ids=tbl_rustagi_branches.branch_id 
			inner join tbl_family_info on tui.user_id=tbl_family_info.user_id 
			".$where;

		// echo $sql;	 
		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		/******Fetch all Members Data from db*********/				
		 $GroomData=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      /******Return to View Model*********/
      	$view = new ViewModel(array('GroomData'=>$GroomData));
		$view->setTerminal(true);
		return $view;
		
		exit();
	}

	public function sidebarFilters()
	{
       $adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

		$filters_array = array("country"=>"tbl_country","profession"=>"tbl_profession","city"=>"tbl_city"
			,"state"=>"tbl_state","education_level"=>"tbl_education_field","designation"=>"tbl_designation");

      	foreach($filters_array as $key =>$table){

      	 		// $row[$key] = $adapter->query("select * from ".$table."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

      	 		// foreach($row[$key] as $cnt){

      	 		// 	$usercount = $select->from('tbl_user_info')->columns(array('COUNT'=>new \Zend\Db\Sql\Expression('COUNT(*)')));
      	 		// 	$field_id[] = $cnt->id;

      	 		// }

      	 	// $filters_data[$key] = array("filter_query"=>$row,"usercount"=>$usercount);
      	 	$filters_data[$key] = $adapter->query("select * from ".$table."", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      	}
      	return $filters_data;
	}

	public function sortmembersAction ()
	{	
		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
       // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');
		$type = $_POST['Type'];

		if($type == "Latest"){

			$where = "where tbl_user_roles.IsMember='1' order by tui.created_date DESC limit 20"; 
		}
		else if($type == "IsExecutive"){

			$where = "where tbl_user_roles.".$_POST['Type']."='1' order by tui.id DESC "; 

		}
		else { 
				$where = "where (tbl_user_roles.IsMember='1' and tui.".$_POST['Type'].">60)";
			 }

			 $sql = "select tui.*,tui.user_id as uid,tbl_user_roles.*,tbl_rustagi_branches.branch_name,tbl_family_info.father_name,tbl_religion.religion_name,tbl_profession.profession,tbl_education_field.education_field,tbl_city.city_name,tbl_height.height,tbl_state.state_name,tbl_country.country_name,tbl_education_level.education_level from tbl_user_info as tui 
			inner join tbl_profession on tui.profession=tbl_profession.id 
			left join tbl_religion on tui.religion=tbl_religion.id 
			left join tbl_education_field on tui.education_field=tbl_education_field.id 
			left join tbl_city on tui.city=tbl_city.id 
			left join tbl_state on tui.state=tbl_state.id 
			left join tbl_country on tui.country=tbl_country.id 
			left join tbl_height on tui.height=tbl_height.id 
			left JOIN tbl_education_level on tui.education_level=tbl_education_level.id
			inner join tbl_user_roles on tui.user_id=tbl_user_roles.user_id 
			inner join tbl_rustagi_branches on tui.branch_ids=tbl_rustagi_branches.branch_id 
			inner join tbl_family_info on tui.user_id=tbl_family_info.user_id ".$where;

		// echo $sql;	 
		$adapter=$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$Members=$adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
      /******Return to View Model*********/
      	$view = new ViewModel(array('GroomData'=>$Members));
      	$view->setTemplate('application/membership/filters');
		$view->setTerminal(true);
		return $view;
		
		exit();	
 
	}
}
?>
