<?php

namespace ZfcAdmin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class NewsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {

        $resultSet = $this->tableGateway->select(function (Select $select) {
                $select->join('tbl_newscategory','tbl_news.news_category_id = tbl_newscategory.id',array("category_name"),Select::JOIN_INNER);
        });

        return $resultSet;
    }

    public function getNews($id) {
        $resultSet = $this->tableGateway->select(array('id'=>$id))->current();
        return $resultSet;
    }

    public function getNewsjoin($id) {
        $resultSet = $this->tableGateway->select(function (Select $select) use($id){
            $select->where(array('tbl_news.id'=>$id));
            $select->join('tbl_newscategory','tbl_news.news_category_id = tbl_newscategory.id',array('category_name'));
            $select->join('tbl_admin_login','tbl_news.modified_by = tbl_admin_login.id',array('username'));
        })->current();

        return $resultSet;
    }

    public function deleteNews($id) {
        $resultSet = $this->tableGateway->delete(array('id'=>$id));
        return $resultSet;
    }

    public function SaveNews($newsEntity)
    {
    	$newsEntity->created_date = (empty($newsEntity->created_date))? date('Y-m-d h:i:s'):$newsEntity->created_date;
                $newsEntity->modified_date = (empty($newsEntity->modified_date))? date('Y-m-d h:i:s'):$newsEntity->modified_date;

    	
                if(!empty($newsEntity->image_path['name'])){

                $filename = $newsEntity->image_path['name'];
                $fileTmpName = $newsEntity->image_path['tmp_name'];
                $filetype = $newsEntity->image_path['type'];
                $filesize = $newsEntity->image_path['size'];
                $filext = pathinfo($filename,PATHINFO_EXTENSION);
                $innerpath = '/img/NewsImages/'.time().$filename;
                $filepath = ROOT_PATH.$innerpath;

                if(in_array($filext, array('jpg','png','gif','JPEG','JPG'))){

                        if($filesize<500000)
                    {
                        // $error = $fileTmpName;
                        // mkdir($bashPath."/uploads/$user_folder", 0777, true);
                       if(move_uploaded_file($fileTmpName, $filepath))
                        $error = "";
                        else $innerpath="";
                    }
                    else  $error = "file size must not be smaller than 5 MB";

                }
                else  $error = "only jpg,png or gif files are allowed";
            }

            else $innerpath="";
                
                // if($error==""){
                //     $success = "ok";
                // }
                // else echo "<script>alert('error');</script>";
                
                // if($success == "ok"){

                    $data = array(
                'title' => $newsEntity->title,
                'description' => $newsEntity->description,
                'IsActive' => $newsEntity->IsActive,
                'news_category_id' => $newsEntity->news_category_id,
                'image_path' => $innerpath,
                'created_date' => $newsEntity->created_date,
                'modified_date' => $newsEntity->modified_date,
                'modified_by' => "1"
                );
                    // print_r($data);die;
                       if($newsEntity->id==0){
                        $resultSet = $this->tableGateway->insert($data);
                        }
                    else {
                                if ($this->getNews($newsEntity->id)) {

                                    $this->tableGateway->update($data, array('id' => $newsEntity->id));

                                    } else {
                                    throw new \Exception('Users id does not exist');
                                }
                        }

                // }

    }


}
