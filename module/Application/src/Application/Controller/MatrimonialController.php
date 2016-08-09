<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
// ini_set("display_errors", 1);

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Application\Controller\AccountController;

class MatrimonialController extends AppController {

    public function indexAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        /*         * ****Fetch Groom Data******** */
        $GroomData = $adapter->query("select tbl_user_info.user_id as uid,tbl_user.id,tbl_user_info.profile_photo,tbl_user_info.name_title_user,tbl_user_info.full_name,tbl_user_info.age
		,tbl_height.height,tbl_city.city_name as city,tbl_religion.religion_name as religion, tbl_education_field.education_field, tbl_education_level.education_level,
		tbl_profession.profession from tbl_user 
		 INNER JOIN tbl_user_info on tbl_user_info.user_id=tbl_user.id
		 LEFT JOIN tbl_height on tbl_user_info.height=tbl_height.id
		 LEFT JOIN tbl_city on tbl_user_info.city=tbl_city.id
		 LEFT JOIN tbl_religion on tbl_user_info.religion=tbl_religion.id
		LEFT JOIN tbl_education_level on tbl_user_info.education_level=tbl_education_level.id
		 LEFT JOIN tbl_education_field on tbl_user_info.education_field=tbl_education_field.id
		LEFT JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
		 LEFT JOIN tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id
		 where tbl_user_info.gender='Male' AND tbl_user_roles.IsMatrimonial='1'  ORDER BY tbl_user.id DESC LIMIT 0,4", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);

        // print_r($GroomData);

        /*         * ****Fetch Brides Data******** */
        $BridesData = $adapter->query("select tbl_user_info.user_id as uid,tbl_user.id,tbl_user_info.profile_photo,tbl_user_info.name_title_user,tbl_user_info.full_name,tbl_user_info.age
		,tbl_height.height,tbl_city.city_name as city,tbl_religion.religion_name as religion,tbl_education_field.education_field,tbl_education_level.education_level
		 , tbl_profession.profession from tbl_user 
		 INNER JOIN tbl_user_info on tbl_user_info.user_id=tbl_user.id
		 LEFT JOIN tbl_height on tbl_user_info.height=tbl_height.id
		 LEFT JOIN tbl_city on tbl_user_info.city=tbl_city.id 
		 LEFT JOIN tbl_religion on tbl_user_info.religion=tbl_religion.id
		 LEFT JOIN tbl_education_field on tbl_user_info.education_field=tbl_education_field.id
		LEFT JOIN tbl_education_level on tbl_user_info.education_level=tbl_education_level.id
		LEFT JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
		LEFT JOIN tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id
		 where tbl_user_info.gender='Female' AND tbl_user_roles.IsMatrimonial='1'  ORDER BY tbl_user.id DESC LIMIT 0,4", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        /*         * ****Return to View Model******** */
        $filters_data = $this->sidebarFilters();

        return new ViewModel(array("GroomData" => $GroomData, "BridesData" => $BridesData, "filters_data" => $filters_data));
    }

    public function listViewAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $search_for = trim($this->params()->fromQuery('search_for'));
        if ($search_for == 'Female') {
            $type = 'Brides';
        } elseif ($search_for == 'Male') {
            $type = 'Grooms';
        } else {
            $type = 'Matrimonial User';
        }
        /*         * ****Fetch User Data******** */
        if ($search_for != '') {
            $UserData = $adapter->query("select tbl_user_info.user_id as uid,tbl_user_roles.*,tbl_user.email,tbl_user.mobile_no,tbl_user_info.*,tbl_family_info.*,
		 tbl_profession.profession,tbl_height.height,tbl_city.city_name as city,tbl_state.state_name as state,tbl_country.country_name as country,
		 tbl_education_field.education_field,tbl_education_level.education_level,tbl_religion.religion_name as religion,tbl_gothra_gothram.gothra_name as caste
		 FROM tbl_user
		INNER JOIN tbl_user_info on tbl_user.id=tbl_user_info.user_id
		INNER JOIN tbl_family_info on tbl_user.id=tbl_family_info.user_id
		LEFT JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
		LEFT JOIN tbl_height on tbl_user_info.height=tbl_height.id
		LEFT JOIN tbl_city on tbl_user_info.city=tbl_city.id
		LEFT JOIN tbl_state on tbl_user_info.state=tbl_state.id
		LEFT JOIN tbl_country on tbl_user_info.country=tbl_country.id
		LEFT JOIN tbl_education_field on tbl_user_info.education_field=tbl_education_field.id
		LEFT JOIN tbl_education_level on tbl_user_info.education_level=tbl_education_level.id
		LEFT JOIN tbl_religion on tbl_user_info.religion=tbl_religion.id
		LEFT JOIN tbl_gothra_gothram on tbl_user_info.gothra_gothram=tbl_gothra_gothram.id
		inner join tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id 
		where tbl_user_info.gender='$search_for' AND tbl_user_roles.IsMatrimonial='1'  ORDER BY tbl_user.id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        } else {
            $UserData = $adapter->query("select tbl_user_info.user_id as uid,tbl_user.email,tbl_user_roles.*,tbl_user.mobile_no,tbl_user_info.*,tbl_family_info.*,
		 tbl_profession.profession,tbl_height.height,tbl_city.city_name as city,tbl_state.state_name as state,tbl_country.country_name as country,
		 tbl_education_field.education_field,tbl_education_level.education_level,tbl_religion.religion_name as religion,tbl_gothra_gothram.gothra_name as caste
		 FROM tbl_user
		INNER JOIN tbl_user_info on tbl_user.id=tbl_user_info.user_id
		INNER JOIN tbl_family_info on tbl_user.id=tbl_family_info.user_id
		LEFT JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
		LEFT JOIN tbl_height on tbl_user_info.height=tbl_height.id
		LEFT JOIN tbl_city on tbl_user_info.city=tbl_city.id
		LEFT JOIN tbl_state on tbl_user_info.state=tbl_state.id
		LEFT JOIN tbl_country on tbl_user_info.country=tbl_country.id
		LEFT JOIN tbl_education_field on tbl_user_info.education_field=tbl_education_field.id
		LEFT JOIN tbl_education_level on tbl_user_info.education_level=tbl_education_level.id
		LEFT JOIN tbl_religion on tbl_user_info.religion=tbl_religion.id
		LEFT JOIN tbl_gothra_gothram on tbl_user_info.gothra_gothram=tbl_gothra_gothram.id
		inner join tbl_user_roles on tbl_user_info.user_id=tbl_user_roles.user_id 
		where tbl_user_roles.IsMatrimonial='1' ORDER BY tbl_user.id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        }
        $filters_data = $this->sidebarFilters();
        // print_r($UserData);die;
        return new ViewModel(array("userinfo" => $UserData, "userType" => $type, "filters_data" => $filters_data));
    }

    public function profileViewAction() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $user_id = intval($this->params()->fromQuery('groom_id'));
        $commanData = array();
        $commanData["officecountry"] = '';
        $commanData["officestate"] = '';
        $commanData["officecity"] = '';
        if ($user_id != '') {

            /*             * ****Fetch User Data******** */
            $UserData = $adapter->query("select tbl_user.email,tbl_user.mobile_no,tbl_user_info.*,tbl_family_info.*,tbl_height.*,
		 tbl_profession.profession,tbl_city.city_name as city,tbl_state.state_name as state,tbl_country.country_name as country,
		 tbl_education_field.education_field,tbl_education_level.education_level,tbl_religion.religion_name as religion,tbl_gothra_gothram.gothra_name as caste,tbl_designation.designation,tbl_annual_income.annual_income FROM tbl_user
		INNER JOIN tbl_user_info on tbl_user.id=tbl_user_info.user_id
		INNER JOIN tbl_family_info on tbl_user.id=tbl_family_info.user_id
		INNER JOIN tbl_profession on tbl_user_info.profession=tbl_profession.id
		LEFT JOIN tbl_city on tbl_user_info.city=tbl_city.id
		LEFT JOIN tbl_state on tbl_user_info.state=tbl_state.id
		left join tbl_height on tbl_user_info.height=tbl_height.id
		LEFT JOIN tbl_country on tbl_user_info.country=tbl_country.id
		LEFT JOIN tbl_education_field on tbl_user_info.education_field=tbl_education_field.id
		LEFT JOIN tbl_education_level on tbl_user_info.education_level=tbl_education_level.id
		LEFT JOIN tbl_religion on tbl_user_info.religion=tbl_religion.id
		LEFT JOIN tbl_gothra_gothram on tbl_user_info.gothra_gothram=tbl_gothra_gothram.id
		LEFT JOIN tbl_designation on tbl_user_info.designation=tbl_designation.id
		LEFT JOIN tbl_annual_income on tbl_user_info.annual_income=tbl_annual_income.id
		WHERE tbl_user.id='$user_id' AND tbl_user_info.user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $records = array();
            foreach ($UserData as $result) {
                $records[] = $result;
            }
            foreach ($records as $userinfo) {
                $office_country = $userinfo->office_country;
                $office_state = $userinfo->office_state;
                $office_city = $userinfo->office_city;
                if ($office_country != '') {
                    $countryName = $this->getOfficialData('tbl_country', $office_country, 'country_name');
                    $commanData["officecountry"] = $countryName;
                }
                if ($office_state != '') {
                    $stateName = $this->getOfficialData('tbl_state', $office_state, 'state_name');
                    $commanData["officestate"] = $stateName;
                }
                if ($office_city != '') {
                    $cityName = $this->getOfficialData('tbl_city', $office_city, 'city_name');
                    $commanData["officecity"] = $cityName;
                }
            }


            $kids_title = unserialize($records[0]['name_title_kids']);
            $kids_name = unserialize($records[0]['kids_name']);
            $kids_status = unserialize($records[0]['kids_status']);
            $kids_dob = unserialize($records[0]['kids_dob']);

            $kids_info = array($kids_title, $kids_name, $kids_status, $kids_dob);

            $records[0]['kids_info'] = $kids_info;


            $brother_title = unserialize($records[0]['name_title_brother']);
            $brother_name = unserialize($records[0]['brother_name']);
            $brother_status = unserialize($records[0]['brother_status']);
            $brother_dob = unserialize($records[0]['brother_dob']);

            $brother_info = array($brother_title, $brother_name, $brother_status, $brother_dob);

            $records[0]['brother_info'] = $brother_info;



            $sister_title = unserialize($records[0]['name_title_sister']);
            $sister_name = unserialize($records[0]['sister_name']);
            $sister_status = unserialize($records[0]['sister_status']);
            $sister_dob = unserialize($records[0]['sister_dob']);

            $sister_info = array($sister_title, $sister_name, $sister_status, $sister_dob);

            $records[0]['sister_info'] = $sister_info;
        } else {
            $UserData = array();
        }
        // echo "<pre>";
        $galleries = $this->galleries($user_id);

        // foreach ($galleries[1] as $key => $value) {
        // 	echo $value[0][0]."<br>";
        // }
        // print_r($galleries[1]);
        // die;
        // print_r($galleries[0]);
        // die;

        $filters_data = $this->sidebarFilters();

        return new ViewModel(array("userinfo" => $records, "officeData" => $commanData, "filters_data" => $filters_data, "galleries" => $galleries));
    }

    public function sidebarFilters() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        // $select=$this->getServiceLocator()->get('Zend\Db\sql\Expression');

        $filters_array = array("country" => "tbl_country", "profession" => "tbl_profession", "city" => "tbl_city"
            , "state" => "tbl_state", "education_level" => "tbl_education_field", "designation" => "tbl_designation"
            , "height" => "tbl_height");

        foreach ($filters_array as $key => $table) {

            $filters_data[$key] = $adapter->query("select * from " . $table . "", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        }

        return $filters_data;
    }

    public function matrimonyfiltersAction() {
        $where = "";

        if (isset($_POST['Country_name'])) {

            $where.=" AND tui.country=" . $_POST['Country_name'];
        }
        if (isset($_POST['State_name'])) {

            $where.=" AND tui.state=" . $_POST['State_name'];
        }
        if (isset($_POST['City_name'])) {

            $where.=" AND tui.city=" . $_POST['City_name'];
        }
        if ($_POST['Zip_pin_code'] != '') {
            $where.=" AND tui.zip_pin_code='" . $_POST['Zip_pin_code'] . "'";
        }
        if ($_POST['Phone_no'] != '') {
            $where.=" AND tui.phone_no='" . $_POST['Phone_no'] . "'";
        }
        if ($_POST['Full_name'] != '') {
            $where.=" AND tui.full_name='" . $_POST['Full_name'] . "'";
        }
        if ($_POST['Office_email'] != '') {
            $where.=" AND tui.office_email='" . $_POST['Office_email'] . "'";
        }
        if ($_POST['Ref_no'] != '') {
            $where.=" AND tui.ref_no='" . $_POST['Ref_no'] . "'";
        }

        if ($_POST['ageMin'] != '' && $_POST['ageMax'] != '') {
            $where.=" AND age BETWEEN '" . $_POST['ageMin'] . "' AND '" . $_POST['ageMax'] . "'";
        }

        if ($_POST['annualIncomeMin'] != '' && $_POST['annualIncomeMax'] != '') {
            $where.=" AND annual_income BETWEEN '" . $_POST['annualIncomeMin'] . "' AND '" . $_POST['annualIncomeMax'] . "'";
        }

        if (isset($_POST['Height'])) {
            $where.=" AND tui.height=" . $_POST['Height'];
        }
        if (isset($_POST['Profession'])) {
            $where.=" AND tui.profession=" . $_POST['Profession'];
        }
        if (isset($_POST['Education_field'])) {
            $where.=" AND tui.education_field=" . $_POST['Education_field'];
        }
        if (isset($_POST['Designation'])) {
            $where.=" AND tui.designation=" . $_POST['Designation'];
        }
        if (isset($_POST['Marital_status'])) {
            $where.=" AND tui.marital_status='" . $_POST['Marital_status'] . "'";
        }
        if (isset($_POST['Manglik_dossam'])) {
            $where.=" AND tui.manglik_dossam='" . $_POST['Manglik_dossam'] . "'";
        }


        //echo "<pre>";
        //echo  $where;exit;
        //$Gtype = $_POST['SearchType'];


        if ($_POST['Female'] == 'Female') {
            $sql = "select tui.*,tui.user_id as uid,tbl_user_roles.*,tbl_profession.profession,tbl_education_field.education_field,tbl_city.city_name,tbl_height.height,tbl_state.state_name,tbl_country.country_name,tbl_education_level.education_level from tbl_user_info as tui 
			inner join tbl_profession on tui.profession=tbl_profession.id 
			left join tbl_designation on tui.designation=tbl_designation.id 
			left join tbl_education_field on tui.education_field=tbl_education_field.id 
			left join tbl_city on tui.city=tbl_city.id 
			left join tbl_state on tui.state=tbl_state.id 
			left join tbl_country on tui.country=tbl_country.id 
			left join tbl_height on tui.height=tbl_height.id 
			left JOIN tbl_education_level on tui.education_level=tbl_education_level.id
			inner join tbl_user_roles on tui.user_id=tbl_user_roles.user_id WHERE tui.gender='" . $_POST['Female'] . "'" . $where;

            //exit;
        }
        if ($_POST['Male'] == 'Male') {
            $sql1 = "select tui.*,tui.user_id as uid,tbl_user_roles.*,tbl_profession.profession,tbl_education_field.education_field,tbl_city.city_name,tbl_height.height,tbl_state.state_name,tbl_country.country_name,tbl_education_level.education_level from tbl_user_info as tui 
			inner join tbl_profession on tui.profession=tbl_profession.id 
			left join tbl_designation on tui.designation=tbl_designation.id 
			left join tbl_education_field on tui.education_field=tbl_education_field.id 
			left join tbl_city on tui.city=tbl_city.id 
			left join tbl_state on tui.state=tbl_state.id 
			left join tbl_country on tui.country=tbl_country.id 
			left join tbl_height on tui.height=tbl_height.id 
			left JOIN tbl_education_level on tui.education_level=tbl_education_level.id
			inner join tbl_user_roles on tui.user_id=tbl_user_roles.user_id WHERE tui.gender='" . $_POST['Male'] . "'" . $where;
        }



        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

        if ($_POST['Female'] == 'Female' && $_POST['Male'] == 'Male') {
            $BridesData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $GroomData = $adapter->query($sql1, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            $view = new ViewModel(array('BridesData' => $BridesData, 'GroomData' => $GroomData, "type" => 'both'));
            $view->setTerminal(true);
            return $view;
        } else {
            if ($_POST['Female'] == 'Female') {
                $BridesData = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                $view = new ViewModel(array('BridesData' => $BridesData, "type" => 'female'));
                $view->setTerminal(true);
                return $view;
            }
            if ($_POST['Male'] == 'Male') {
                $GroomData = $adapter->query($sql1, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                $request = $this->getRequest();
                $view = new ViewModel(array('GroomData' => $GroomData, "type" => 'male'));
                $view->setTerminal(true);
                return $view;
            }
        }
    }

}

?>
