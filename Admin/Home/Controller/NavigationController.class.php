<?php
namespace Home\Controller;

use Think\Controller;
use Think\Page;
use Org\Util\Date;
use Home\Model\MainModel;

class NavigationController extends MainController {

    //导航栏 通用类
    public  function ruKou(){
        $_SESSION['type_id']=intval($_GET['id']);
        $this->redirect("show");
    }
    public  function CountRuKou(){
        $_SESSION['count']=intval($_GET['id']);
        $this->redirect("showSome");
    }
    public function showAdd(){
        //导航栏
        $sql=M('news_main');
        $id = intval($_SESSION['type_id']);
        $where['type_id']=0;
        $result1=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
        
        //左栏首页
        $sql=M('home_page');
        $where['type_id']=0;
        $result2=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result2',$result2);

        $this->display();
    }
     public function show(){
    
        import("ORG.Util.Page");//导入分页助手类
        $id = intval($_SESSION['type_id']);
        $sql=M('news_main');
        $where['type_id']=$id;
        $where['count'] = 0;
        $total = $sql->where($where)->count();
        $num_per_page = 10;
        $page = new Page($total,$num_per_page);
         
        $page->setConfig('header','篇文章');
        $show = $page->show();
         
        $result=$sql
        ->where($where)
        ->limit("$page->firstRow,$page->listRows")
        ->order("addtime desc")
        ->select();
        $this->assign('result',$result);
        $this->assign('show',$show);
        //导航栏
        $where1['type_id']=0;
        $result1=$sql->where($where1)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        //dump($result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
        
        //左栏首页
        $sql=M('home_page');
        $where2['type_id']=0;
        $result2=$sql->where($where2)->order("news_id asc")->select();
        $this->assign('result2',$result2);
        
        $cnt=1;
        $this->assign('cnt',$cnt);
        $this->display();
    } 
    public function add(){
    
        header("content-type:text/html;charset=utf-8");
        $type_id = intval($_SESSION['type_id']);
        $title    = htmlspecialchars($_POST['texttitle1']);
        $content  = htmlspecialchars($_POST['content1']);
        if($_POST['date1']=='')
            $time = Date('Y-m-d H:i:s');
        else
            $time = $_POST['date1'];
        $count = 0;
        if (empty($title)||empty($content)){
    
            echo "<script>alert('标题或者内容不能为空!');
              location.href='showAdd';</script>";
    
        }else{
            // new model
            $m = new MainModel();
            //MainModel::instance();
            $m->add($type_id,$title,$content,$time,$count);
            echo "<script language='javascript'>\n";
            echo "alert('添加成功');\n";
            echo "location.href='show';\n";
            echo "</script>";
        }
    }
    public function del(){
        header("content-type:text/html;charset=utf-8");
    
        $id = intval($_GET['id']);
        D('Main')->del($_SESSION['type_id'],$id);
        $url= U('Home/Navigation/show');
        $this->success('删除成功',$url,5);
    }
    public function upd(){
        $id= intval($_GET['id']);
        $info = D('Main')->showUpd($_SESSION['type_id'],$id);
        $this->assign('res',$info[0]);
        
        $sql=M('news_main');
        $id = $_SESSION['type_id'];
        $where['type_id']=0;
        $result1=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
        
        //左栏首页
        $sql=M('home_page');
        $where['type_id']=0;
        $result2=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result2',$result2);
        
        $this->display();
    }
    public function updJudge(){
        header("content-type:text/html;charset=utf-8");
    
        $id = intval($_POST['id']);
        $time = $_POST['date1'];
        $textinfo['type_id']= $_SESSION['type_id'];
        $textinfo['title']= htmlspecialchars($_POST['texttitle1']);
        $textinfo['content']= htmlspecialchars($_POST['content1']);
        $textinfo['addtime']= $time;
        $textinfo['count']= 0;
    
        D('Main')->upd($_SESSION['type_id'],$id,$textinfo);
         
        echo "<script>alert('修改成功!');
              location.href='show';</script>";
    }
    

    
public function showAddSet(){
        //导航栏
        $sql=M('news_main');
        $id = intval($_SESSION['type_id']);
        $where['type_id']=0;
        $result1=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
        
        //左栏首页
        $sql=M('home_page');
        $where['type_id']=0;
        $result2=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result2',$result2);
 
        $this->display();
    }
     public function showSet(){
    
        import("ORG.Util.Page");//导入分页助手类
        $sql=M('news_main');
        $where['type_id']=0;
    
        $total = $sql->where($where)->count();
        $num_per_page = 10;
        $page = new Page($total,$num_per_page);
         
        $page->setConfig('header','篇文章');
        $show = $page->show();
         
        $result=$sql
        ->where($where)
        ->limit("$page->firstRow,$page->listRows")
        ->order("news_id asc")
        ->select();
        $this->assign('result',$result);
        $this->assign('show',$show);
        //导航栏
        $where['type_id']=0;
        $result1=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
        
        //左栏首页
        $sql=M('home_page');
        $where['type_id']=0;
        $result2=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result2',$result2);
        
        $this->display();
    } 
    public function addSet(){
    
        header("content-type:text/html;charset=utf-8");
        $type_id = 0;
        $title    = htmlspecialchars($_POST['texttitle1']);
        $time     = Date('Y-m-d H:i:s');
        $count = 0;
        if (empty($title)){
    
            echo "<script>alert('标题不能为空!');
              location.href='showAddSet';</script>";
    
        }else{
    
            D('Main')->add($type_id,$title,$content,$time,$count);
            echo "<script language='javascript'>\n";
            echo "alert('添加成功');\n";
            echo "location.href='showSet';\n";
            echo "</script>";
        }
    }
    public function delSet(){
        header("content-type:text/html;charset=utf-8");
        $id = intval($_GET['id']);
        D('Main')->del(0,$id);
        $url= U('Home/Navigation/showSet');
        $this->success('删除成功',$url,5);
    }
    public function updSet(){
        $id= intval($_GET['id']);
        $info = D('Main')->showUpd(0,$id);
        $this->assign('res',$info[0]);
        
        $id = $_SESSION['type_id'];
        //左栏导航
        $sql=M('news_main');
        $where['type_id']=0;
        $result1=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
        
        //左栏首页
        $sql=M('home_page');
        $where['type_id']=0;
        $result2=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result2',$result2);    
        
        $this->display();
    }
    public function updSetJudge(){
        header("content-type:text/html;charset=utf-8");
        $sql = M('news_main');
        $where['type_id'] = 0;
        $where['news_id'] = intval($_POST['id1']);
        $ret=$sql->where($where)->select();
        if (!empty($ret)){
            $url = $url= U('Home/Navigation/updSet');;
            $this->error('已经存在此id',$url,5);
        }  
        $id = intval($_POST['id']);
        $time = Date('Y-m-d H:i:s');
        $textinfo['type_id']= 0;
        $textinfo['news_id'] = intval($_POST['id1']);
        $textinfo['title']= htmlspecialchars($_POST['texttitle1']);
        $textinfo['addtime']= $time;
        $textinfo['count']= 0;
    
        D('Main')->upd(0,$id,$textinfo);
        $save_where['type_id'] = $id;
        $save_data['type_id'] = intval($_POST['id1']);
        $sql->where($save_where)->save($save_data);
        echo "<script>alert('修改成功!');
              location.href='showSet';</script>";
    }
    
    
    public function showAddSome(){
        //导航栏
        $sql=M('news_main');
        $id = intval($_SESSION['type_id']);
        $where['type_id']=0;
        $result1=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
    
        //左栏首页
        $sql=M('home_page');
        $where['type_id']=0;
        $result2=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result2',$result2);
    
        $this->display();
    }
    public function addSome(){
    
        header("content-type:text/html;charset=utf-8");
        $type_id = intval($_SESSION['type_id']);
        $title    = htmlspecialchars($_POST['texttitle1']);
        if($_POST['date1']=='')
            $time = Date('Y-m-d H:i:s');
        else
            $time = $_POST['date1'];
        $count = 0;
        if (empty($title)){
    
            echo "<script>alert('标题不能为空!');
              location.href='showAdd';</script>";
    
        }else{
            // new model
            $m = new MainModel();
            //MainModel::instance();
            $m->add($type_id,$title,$content,$time,$count);
            echo "<script language='javascript'>\n";
            echo "alert('添加成功');\n";
            echo "location.href='show';\n";
            echo "</script>";
        }
    }
    
    public function showSome(){
    
        import("ORG.Util.Page");//导入分页助手类
        $id= intval($_SESSION['type_id']);
        $sql=M('news_main');
        $where['count']=intval($_SESSION['count']);
        $where['type_id']=$id;
        $total = $sql->where($where)->count();
        $num_per_page = 10;
        $page = new Page($total,$num_per_page);
         
        $page->setConfig('header','篇文章');
        $show = $page->show();
         
        $result=$sql
        ->where($where)
        ->limit("$page->firstRow,$page->listRows")
        ->order("addtime desc")
        ->select();
        $this->assign('result',$result);
        $this->assign('show',$show);
        //导航栏
        $where1['type_id']=0;
        $result1=$sql->where($where1)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
        
        $whereSecond['type_id']=$id;
        $whereSecond['news_id']=intval($_SESSION['count']);
        $resSecond = $sql->where($whereSecond)->select();
        $this->assign('resSecondTil',$resSecond[0]['title']);
        //左栏首页
        $sql=M('home_page');
        $where2['type_id']=0;
        $result2=$sql->where($where2)->order("news_id asc")->select();
        $this->assign('result2',$result2);
    
        $cnt=1;
        $this->assign('cnt',$cnt);
        $this->display();
    }
    
    public function showAddSomeOne(){
        //导航栏
        $sql=M('news_main');
        $id = intval($_SESSION['type_id']);
        $where['type_id']=0;
        $result1=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
    
        $whereSecond['type_id']=$id;
        $whereSecond['news_id']=intval($_SESSION['count']);
        $resSecond = $sql->where($whereSecond)->select();
        $this->assign('resSecondTil',$resSecond[0]['title']);
        //左栏首页
        $sql=M('home_page');
        $where['type_id']=0;
        $result2=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result2',$result2);
    
        $this->display();
    }
    
    public function addSomeOne(){
    
        header("content-type:text/html;charset=utf-8");
        $type_id = intval($_SESSION['type_id']);
        $title    = htmlspecialchars($_POST['texttitle1']);
        $content  = htmlspecialchars($_POST['content1']);
        if($_POST['date1']=='')
            $time = Date('Y-m-d H:i:s');
        else
            $time = $_POST['date1'];
        $count = $_SESSION['count'];
        if (empty($title)||empty($content)){
    
            echo "<script>alert('标题或者内容不能为空!');
              location.href='showAddSomeOne';</script>";
    
        }else{
            // new model
            $m = new MainModel();
            //MainModel::instance();
            $m->add($type_id,$title,$content,$time,$count);
            echo "<script language='javascript'>\n";
            echo "alert('添加成功');\n";
            echo "location.href='showSome';\n";
            echo "</script>";
        }
    }
    public function delSomeOne(){
        header("content-type:text/html;charset=utf-8");
    
        $id = intval($_GET['id']);
        D('Main')->del($_SESSION['type_id'],$id);
        $url= U('Home/Navigation/showSome');
        $this->success('删除成功',$url,5);
    }
    public function updSomeOne(){
        $id= intval($_GET['id']);
        $info = D('Main')->showUpd($_SESSION['type_id'],$id);
        $this->assign('res',$info[0]);
    
        $sql=M('news_main');
        $id = $_SESSION['type_id'];
        $where['type_id']=0;
        $result1=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result1',$result1);
        foreach ($result1 as $key=>$val){
            if($result1[$key]['news_id']==$id){
                $til = $val;
            }
        }
        $this->assign('til',$til['title']);
        
        $whereSecond['type_id']=$id;
        $whereSecond['news_id']=intval($_SESSION['count']);
        $resSecond = $sql->where($whereSecond)->select();
        $this->assign('resSecondTil',$resSecond[0]['title']);
        //左栏首页
        $sql=M('home_page');
        $where['type_id']=0;
        $result2=$sql->where($where)->order("news_id asc")->select();
        $this->assign('result2',$result2);
    
        $this->display();
    }
    public function updJudgeSomeOne(){
        header("content-type:text/html;charset=utf-8");
    
        $id = intval($_POST['id']);
        $time = $_POST['date1'];
        $textinfo['type_id']= $_SESSION['type_id'];
        $textinfo['title']= htmlspecialchars($_POST['texttitle1']);
        $textinfo['content']= htmlspecialchars($_POST['content1']);
        $textinfo['addtime']= $time;
        $textinfo['count']= intval($_SESSION['count']);
    
        D('Main')->upd($_SESSION['type_id'],$id,$textinfo);
         
        echo "<script>alert('修改成功!');
              location.href='showSome';</script>";
    }
}