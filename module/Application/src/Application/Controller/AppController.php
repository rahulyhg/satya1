<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\EventManager\EventManagerInterface;

class AppController extends AbstractActionController {

    protected $_userTable, $_userTypeTable, $_gothraTable, $_professionTable, $_emailLogsTable, $_userInfoTable,
            $_EducationLevelTable, $_EducationFieldTable, $_CountryTable, $_StateTable, $_CityTable, $_AnnualIncomeTable, $_HeightTable,
            $_ReligionTable, $_FamilyInfoTable, $_DesignationTable, $_RustagiBranchTable, $_PostcategoryTable, $_PostTable;

    public function setEventManager(EventManagerInterface $events) {
        parent::setEventManager($events);

        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            $auth = array('Application\Controller\Account');
            if (in_array($controller->params('controller'), $auth))
                $this->CheckLogin();
        }, 100); // execute before executing action logic
        //************by maninder
        $events->attach('dispatch', function ($e) use ($controller) {
            $auth = array('Application\Controller\User');
            if (in_array($controller->params('controller'), $auth))
                $this->CheckLogout();
        }, 100);
        //**********************		
    }

    public function CheckLogin() {
        $user_session = new Container('user');
        if ($user_session->offsetGet('id') == "" && $user_session->offsetGet('email') == "")
            return $this->redirect()->toRoute("application/default");
    }

    public function CheckLogout() {
        $user_session = new Container('user');
        if ($user_session->offsetGet('id') != "" && $user_session->offsetGet('email') != "")
            return $this->redirect()->toRoute("application/default", array('controller' => 'account', 'action' => 'memberbasic'));
    }

    public function BloodGroup() {
        $blood_group = array("Dont Know" => "Dont Know", "A+" => "A+", "A-" => "A-", "B+" => "B+", "B-" => "B-", "AB+" => "AB+", "AB-" => "AB-", "O+" => "O+", "O-" => "O-");
        return $blood_group;
    }

    public function MeritalStatus() {
        $marital_status = array("Single" => "Single",
            "Married" => "Married",
            "Divorced" => "Divorced",
            "Widowed" => "Widowed",
            "Separated" => "Separated");
        return $marital_status;
    }

    public function EmploymentStatus() {
        $Employment_status = array("Homemaker" => "Homemaker",
            "Employed" => "Employed",
            "Business" => "Business",
            "Professional" => "Professional",
            "Retired" => "Retired",
            "Not Employed" => "Not Employed",
            "Passed Away" => "Passed Away",
            "Others" => "Others");
        return $Employment_status;
    }

    public function LiveStatus() {
        $LiveStatus = array("Alive" => "Alive", "Passed Away" => "Passed Away");
        return $LiveStatus;
    }

    public function WorkingWithCompany() {
        $Working_with = array("Private Company" => "Private Company",
            "Government / Public Sector" => "Government / Public Sector",
            "Defense / Civil Services" => "Defense / Civil Services",
            "Business / Self Employed" => "Business / Self Employed",
            "Non Working" => "Non Working",
            "Others" => "Others");
        return $Working_with;
    }

    public function getAge() {
        $AGE = array();
        for ($i = 1; $i <= 150;) {
            $AGE[$i] = $i;
            $i++;
        }
        return $AGE;
    }

    public function AffluenceLevelStatus() {
        $affluencelevel_status = array("Affluent" => "Affluent",
            "Upper Middle Class" => "Upper Middle Class",
            "Middle Class" => "Middle Class",
            "Lower Middle Class" => "Lower Middle Class");
        return $affluencelevel_status;
    }

    public function FamilyValuesStatus() {
        $familyvalues_status = array("Traditional" => "Traditional",
            "Moderate" => "Moderate",
            "Liberal" => "Liberal");
        return $familyvalues_status;
    }

    public function GetNameTitle() {
        $NameTitle = array("Mr" => "Mr",
            "Miss" => "Miss",
            "Dr" => "Dr",
            "Prof" => "Prof",
            "Retd" => "Retd",
            "Major" => "Major",
            "Sh" => "Sh",
            "Smt" => "Smt");
        return $NameTitle;
    }

    public function getOfficialData($TableName, $offset, $fieldName) {
        $returnValue = '';
        if ($TableName != '' && $offset != '' && $offset != 0 && $fieldName != '') {
            $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $GroomData = $adapter->query("select $fieldName from $TableName where id='$offset'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            foreach ($GroomData as $offName)
                ;
            $returnValue = $offName->$fieldName;
            return $returnValue;
        }
        return $returnValue;
    }

#########################################################################################################

    public function getUserTable() {

        if (!$this->_userTable) {
            $sm = $this->getServiceLocator();
            $this->_userTable = $sm->get('Application\Model\UserTable');
        }
        return $this->_userTable;
    }

    ####### Function to make Drop down for User Type #########

    public function getUserTypeTable() {
        if (!$this->_userTypeTable) {
            $sm = $this->getServiceLocator();
            $this->_userTypeTable = $sm->get('Application\Model\UserTypeTable');
        }
        return $this->_userTypeTable;
    }

    ####### Function to make Drop down for Profession #########

    public function getGothraTable() {
        if (!$this->_gothraTable) {
            $sm = $this->getServiceLocator();
            $this->_gothraTable = $sm->get('Application\Model\GothraTable');
        }
        return $this->_gothraTable;
    }

    ####### Function to make Drop down for Gothra #########

    public function getProfessionTable() {
        if (!$this->_professionTable) {
            $sm = $this->getServiceLocator();
            $this->_professionTable = $sm->get('Application\Model\ProfessionTable');
        }
        return $this->_professionTable;
    }

#########################################################################################################

    public function getEmailLogsTable() {

        if (!$this->_emailLogsTable) {
            $sm = $this->getServiceLocator();
            $this->_emailLogsTable = $sm->get('Application\Model\EmailLogsTable');
        }
        return $this->_emailLogsTable;
    }

#########################################################################################################

    public function getUserInfoTable() {

        if (!$this->_userInfoTable) {
            $sm = $this->getServiceLocator();
            $this->_userInfoTable = $sm->get('Application\Model\UserInfoTable');
        }
        return $this->_userInfoTable;
    }

    public function getEducationLevelTable() {

        if (!$this->_EducationLevelTable) {
            $sm = $this->getServiceLocator();
            $this->_EducationLevelTable = $sm->get('Application\Model\EducationLevelTable');
        }
        return $this->_EducationLevelTable;
    }

    public function hello() {

        return "munanshu";
    }

    public function getCountryTable() {

        if (!$this->_CountryTable) {
            $sm = $this->getServiceLocator();
            $this->_CountryTable = $sm->get('Application\Model\CountryTable');
        }
        return $this->_CountryTable;
    }

    public function getStateTable() {

        if (!$this->_StateTable) {
            $sm = $this->getServiceLocator();
            $this->_StateTable = $sm->get('Application\Model\StateTable');
        }
        return $this->_StateTable;
    }

    public function getCityTable() {

        if (!$this->_CityTable) {
            $sm = $this->getServiceLocator();
            $this->_CityTable = $sm->get('Application\Model\CityTable');
        }
        return $this->_CityTable;
    }

    public function getAnnualIncomeTable() {

        if (!$this->_AnnualIncomeTable) {
            $sm = $this->getServiceLocator();
            $this->_AnnualIncomeTable = $sm->get('Application\Model\AnnualIncomeTable');
        }
        return $this->_AnnualIncomeTable;
    }

    public function getHeightTable() {

        if (!$this->_HeightTable) {
            $sm = $this->getServiceLocator();
            $this->_HeightTable = $sm->get('Application\Model\HeightTable');
        }
        return $this->_HeightTable;
    }

    public function getEducationFieldTable() {

        if (!$this->_EducationFieldTable) {
            $sm = $this->getServiceLocator();
            $this->_EducationFieldTable = $sm->get('Application\Model\EducationFieldTable');
        }
        return $this->_EducationFieldTable;
    }

    public function getReligionTable() {

        if (!$this->_ReligionTable) {
            $sm = $this->getServiceLocator();
            $this->_ReligionTable = $sm->get('Application\Model\ReligionTable');
        }
        return $this->_ReligionTable;
    }

    public function getFamilyInfoTable() {

        if (!$this->_FamilyInfoTable) {
            $sm = $this->getServiceLocator();
            $this->_FamilyInfoTable = $sm->get('Application\Model\FamilyInfoTable');
        }
        return $this->_FamilyInfoTable;
    }

    public function getDesignationTable() {

        if (!$this->_DesignationTable) {
            $sm = $this->getServiceLocator();
            $this->_DesignationTable = $sm->get('Application\Model\DesignationTable');
        }
        return $this->_DesignationTable;
    }

    public function getRustagiBranchTable() {

        if (!$this->_RustagiBranchTable) {
            $sm = $this->getServiceLocator();
            $this->_RustagiBranchTable = $sm->get('Application\Model\RustagiBranchTable');
        }
        return $this->_RustagiBranchTable;
    }

    public function getPostcategoryTable() {

        if (!$this->_PostcategoryTable) {
            $sm = $this->getServiceLocator();
            $this->_PostcategoryTable = $sm->get('Application\Model\PostcategoryTable');
        }
        return $this->_PostcategoryTable;
    }

    public function getPostTable() {

        if (!$this->_PostTable) {
            $sm = $this->getServiceLocator();
            $this->_PostTable = $sm->get('Application\Model\PostTable');
        }
        return $this->_PostTable;
    }

    public function familyimages($post, $files) {
        $resp = $this->getResponse();
        $resp->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $img_relation = trim($post['field_name']);
        $name = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];
        $error = $_FILES['file']['error'];
        $size = $_FILES['file']['size'];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        switch ($error) {
            case UPLOAD_ERR_OK:
                $valid = true;
                //validate file extensions
                if (!in_array($ext, array('jpg'))) {
                    $valid = false;
                    $response = "Invalid file extension. Only( jpg ) are allowed";
                }
                //validate file size
                if ($size / 1024 / 1024 > 2) {
                    $valid = false;
                    $response = "File size is exceeding 2MB maximum allowed size.";
                }
                //upload file
                if ($valid) {

                    // return $post;
                    $bashPath = ROOT_PATH;
                    $session = new Container('user');
                    $user_id = $session->offsetGet('id');
                    // $ref_no=$session->offsetGet('ref_no');
                    $user_name = $session->offsetGet('full_name');
                    $user_folder = $user_id . "__" . $user_name . "/familyimages";
                    $name = time() . $name;
                    if (!file_exists($bashPath . "/uploads/$user_folder")) {
                        mkdir($bashPath . "/uploads/$user_folder", 0777, true);
                        $targetPath = $bashPath . "/uploads/$user_folder/" . $name;
                        $uploaded = move_uploaded_file($tmpName, $targetPath);
                    } else {
                        $targetPath = $bashPath . "/uploads/$user_folder/" . $name;
                        $uploaded = move_uploaded_file($tmpName, $targetPath);
                    }
                    if ($uploaded) {
                        if ($post['field_name'] == "profile_photo") {
                            $session = new Container('user');
                            $prophoto = '/uploads/' . $user_folder . "/" . $name;
                            $session->profile_photo = $prophoto;
                        }

                        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                        //*********Insert in Gallery Table******
                        $adapter->query("update " . $post['table_name'] . " set " . $post['field_name'] . "='/uploads/$user_folder/$name' where user_id=$user_id ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                        //*********Select Images to Render******
                        // $data=$adapter->query("select ".$post['field_name']." from tbl_family_info where user_id='$user_id'", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
                        $response = 'File uploaded Successfully.';
                        // return $data;
//for testing purpose		
                        $imgidpath = "/rustagi/uploads/$user_folder/$name";
                        $resp->setContent(json_encode(array("Status" => 1, "data" => $imgidpath, "imgid" => $post['field_name'])));
//for live purpose
// $imgidpath = "/uploads/$user_folder/$name";
                        //        $resp->setContent(json_encode(array("Status"=>1,"data"=>$imgidpath,"imgid"=>$post['field_name'])));

                        return $resp;

                        // return new JsonModel(array("Status"=>1,"data"=>$targetPath));
                        // return new JsonModel(array("Status"=>"true","message"=>$response,"family_data"=>$data));							
                    } else {
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

        $resp->setContent(json_encode(array("Status" => 0, "message" => $response)));
        return $resp;

        // return new JsonModel(array("Status"=>0,"message"=>$response));
        // return $response; 
        // return $post;
    }

    public function galleries($user_id) {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        // $session = new Container('user');
        //        $user_id=$session->offsetGet('id');
        //        $ref_no=$session->offsetGet('ref_no');
        $data = $adapter->query("select * from tbl_user_gallery where user_id='$user_id' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

        $metadata = new \Zend\Db\Metadata\Metadata($adapter);
        $table = $metadata->getTable("tbl_family_info");
        $table->getColumns();

        foreach ($table->getColumns() as $column) {
            if (strpos($column->getName(), "photo") || strpos($column->getName(), "_name")) {
                $columns[] = $column->getName();
            }
        }
        $Fphotos = array();
        $Pphotos = array();
        // foreach ($columns as $key => $value) {
        $Fdata = $adapter->query("select * from tbl_family_info where user_id='$user_id' ORDER BY id DESC", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        // }
        foreach ($Fdata as $F_data) {
            foreach ($columns as $key => $value) {
                if (strpos($value, "photo")) {
                    if (empty($F_data->$value))
                        continue;
                    else
                        $Fphotos[] = array(array($F_data->$value, $value), array($F_data->$columns[$key - 1], $columns[$key - 1]));
                }
            }
        }

        foreach ($data as $P_data) {
            foreach ($P_data as $key => $value) {

                if ($key == "image_path")
                    $Pphotos[] = $value;
            }
        }

        // echo "<pre>";
        shuffle($Fphotos);
        shuffle($Pphotos);

        // print_r($Fphotos);
        // die;
        return array($Pphotos, $Fphotos);
    }

    public function ProfileBar() {
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $session = new Container('user');
        $user_id = $session->offsetGet('id');
        // $ref_no=$session->offsetGet('ref_no');
        $data = $adapter->query("select * from tbl_user_info as tui inner join tbl_family_info as tfi on 
            tui.user_id = tfi.user_id where tui.user_id=$user_id", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();

        $totalfields = count($data[0]);

        $arr = array('id', "ref_no", "user_id", "user_type_id", "comm_mem_id", "comm_mem_status", "ip", "created_date", "modified_date");
        $c = 0;
        foreach ($data[0] as $key => $value) {
            if (in_array($key, $arr))
                continue;
            if (!empty($value))
                $c++;
            // echo $value."<br>";
        }

        $per = ceil(($c / $totalfields) * 100);

        return array($per, $this->profilescript(ceil($per)));
    }

    public function profilescript($per = '') {
        # code...
        $str = "(function($) {
    $.fn.waterbubble = function(options) {
            var config = $.extend({
                radius: 50,
                lineWidth: undefined,
                data: $per/100,
                waterColor: 'rgba(208, 111, 0, 0.3)',
                textColor: 'rgba(13, 23, 0, 0.5)',
                font: '',
                wave: true,
                txt: undefined,
                animation: true
            }, options);

            var canvas = this[0];
            config.lineWidth = config.lineWidth ? config.lineWidth : config.radius/24;

            var waterbubble = new Waterbubble(canvas, config);

            return this;
        }
        

        function Waterbubble (canvas, config) {
            this.refresh(canvas, config);
        }

        Waterbubble.prototype = {
            refresh: function (canvas, config) {
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
                this._init(canvas, config)
            },

            _init: function (canvas, config){
                var radius = config.radius;
                var lineWidth = config.lineWidth;

                canvas.width = radius*2 + lineWidth;
                canvas.height = radius*2 + lineWidth;

                this._buildShape(canvas, config);
            },

            _buildShape: function (canvas, config) {

                var ctx = canvas.getContext('2d');

                var gap = config.lineWidth*2;
                //raidus of water
                var r = config.radius - gap;
                var data = config.data;
                var lineWidth = config.lineWidth

                var waterColor = config.waterColor;
                var textColor = config.textColor;
                var font = config.font;

                var wave = config.wave

                // //the center of circle
                var x = config.radius + lineWidth/2;
                var y = config.radius + lineWidth/2;

                ctx.beginPath();
                
                ctx.arc(x, y, config.radius, 0, Math.PI*2);
                ctx.lineWidth = lineWidth;
                ctx.strokeStyle = waterColor;
                ctx.stroke();
                if (typeof config.txt == 'string'){
                    this._drawText(ctx, textColor, font, config.radius, data, x, y, config.txt);
                }
                //if config animation true
                if (config.animation) {
                    this._animate(ctx, r, data, lineWidth, waterColor, x, y, wave, config.txt, textColor, font)
                } else {
                    this._fillWater(ctx, r, data, lineWidth, waterColor, x, y, wave);
                }

                return;
            },

            _fillWater: function (ctx, r, data, lineWidth, waterColor, x, y, wave) {
                // this.refresh(canvas, config);
                ctx.beginPath();

                ctx.globalCompositeOperation = 'destination-over';

                //start co-ordinates
                var sy = r*2*(1 - data) + (y - r);
                var sx = x - Math.sqrt((r)*(r) - (y - sy)*(y - sy));
                //middle co-ordinates
                var mx = x;
                var my = sy;
                //end co-ordinates
                var ex = 2*mx - sx;
                var ey = sy;

                var extent; //extent

                if (data > 0.9 || data < 0.1 || !wave) {
                    extent = sy
                } else{
                    extent = sy - (mx -sx)/4
                }

                ctx.beginPath();
                
                ctx.moveTo(sx, sy)
                ctx.quadraticCurveTo((sx + mx)/2, extent, mx, my);
                ctx.quadraticCurveTo((mx + ex)/2, 2*sy - extent, ex, ey);

                var startAngle = -Math.asin((x - sy)/r)
                var endAngle = Math.PI - startAngle;

                ctx.arc(x, y, r, startAngle, endAngle, false)

                ctx.fillStyle = waterColor;
                ctx.fill()
            },

            _drawText: function (ctx, textColor, font, radius, data, x, y, txt) {
                ctx.globalCompositeOperation = 'source-over';

                var size = font ? font.replace( /\D+/g, '') : 0.4*radius;
                ctx.font = font ? font : 'bold ' + size + 'px Microsoft Yahei';

                txt = txt.length ? txt : data*100 + '%'

                var sy = y + size/2;
                var sx = x - ctx.measureText(txt).width/2

                ctx.fillStyle = textColor;
                ctx.fillText(txt, sx, sy)
            },

            _animate: function (ctx, r, data, lineWidth, waterColor, x, y, wave, txt, textColor, font) {
                var datanow = {
                    value: 0
                };
                var requestAnimationFrame = window.requestAnimationFrame || window.msRequestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || function (func) {
                    setTimeout(func, 16);
                };
                var self = this;
                var update = function () {
                    if (datanow.value < data) {
                        datanow.value += (data + 0.05 - datanow.value)/15
                        self._runing = true;
                    } else {
                        self._runing = false;
                    }
                }
                var step = function () {
                    self._fillWater(ctx, r, datanow.value, lineWidth, waterColor, x, y, wave);
                    update();
                    if (self._runing) {
                        requestAnimationFrame(step);
                    }
                }
                step(ctx, r, datanow, lineWidth, waterColor, x, y, wave, txt)
            }
        }
}(jQuery)); ";

        return $str;
    }

}
