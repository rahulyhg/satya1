<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\Db\Adapter\Adapter;

class MyHelper extends AbstractHelper
{
     
  protected $model,$sql;

    public function __construct($model, $dbAdapter)
    {
       $this->model= $dbAdapter;
         // $this->model = $model;
        // $this->adapter = mysqli_connect("10.0.0.35","root","root","db_rustagi_samaj");
//         $this->model = new \Zend\Db\Adapter\Adapter(array(
//            'driver' => 'pdo_mysql',
//            'dsn' => 'mysql:dbname=db_rustagi_samaj;host=10.0.0.35' ,
//			//'dsn' => 'mysql:dbname=rustagis_db_rustagi_sabhanew;host=103.228.152.14' ,    
//            'user' => 'root',
//            'password' => 'root',
//            'database' => 'db_rustagi_samaj',
//			//'user' => 'rustagis_new',
//           // 'password' => 'Hello(42)',
//           // 'database' => 'rustagis_db_rustagi_sabhanew',
//        ));
//         $this->sql = new \Zend\Db\Sql\Sql($this->model);
       $this->sql = new \Zend\Db\Sql\Sql($this->model);
    }

    public function myCoolModelMethod()
    {
        return $this->model->fetchAll();
    }

    public function PopPosts()
    {
        // $res = $this->adapter->query("select * from tbl_post");

        // return $res;
        // $select = new \Zend\Db\Sql\Select('tbl_post');
        // $select->limit(2);
        // $select->order('id DESC');
        // // ->offset(15);
        // $selectString = $this->sql->getSqlStringForSqlObject($select);
        // $statement = $this->sql->prepareStatementForSqlObject($selectString);
        // return $statement->execute();
        $results = $this->model->query("SELECT tbl_post.*, count(tbl_posts_views.post_id) as views        
from tbl_post
left join tbl_posts_views
on (tbl_post.id = tbl_posts_views.post_id)
group by
    tbl_post.id
order by views DESC
limit 2", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $results;
    }

    public function PostCat($cat='')
    {
         $results = $this->model->query("call view_count($cat)", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
         $CommentCounts = $this->model->query("select post_id from tbl_posts_comments where post_id='".$results[0]['id']."' ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->count();
         
         $comments = $this->model->query("select tpc.*,tui.profile_photo from tbl_posts_comments as tpc 
            left join tbl_user_info as tui on tpc.user_id = tui.user_id 
            where tpc.post_id='".$results[0]['id']."' order by tpc.id desc limit 2", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
         $results[0]['comments'] = $CommentCounts; 
         $results[0]['CommentDesc'] = $comments; 


        return $results[0];
    }

     public function CurrNews()
    {
         $results = $this->model->query("select title,created_date,description,id from tbl_news order by id DESC limit 2 ", \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)->toArray();
        return $results;
    }

}

