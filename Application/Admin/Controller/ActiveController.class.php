<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Page;

class ActiveController extends Controller{



    public  function index(){
        $m=M('active');
//        dump($m);exit;
//       $document =M('document')->find();
        import('ORG.Util.Page');// 导入分页类
        $count    = $m->count();// 查询满足要求的总记录数
        $page    = new Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数
        $page->setConfig('header','条信息');
        $show = $page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $list  = $m->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
//        $this->assign('document',$document);// 赋值数据集

        $this->display('index');
    }


    public function active($active_id){
        $uid=session('user_auth')['uid'];
        //根据uid和活动id去数据表查询

        $Model=M('active');
        $user = $Model->where(['uid'=>$uid,'active_id'=>$active_id])->find();
        if($user){
            $this->error('你已申请过此活动');
        }else{
            $member = M('member')->find($uid);
            $active=M('document')->find($active_id);
            $Model->uid=$uid;
            $Model->active_id=$active_id;
            $Model->name=$member['nickname'];
            $Model->description=$active['description'];
            $Model->status=0;
            $Model->apply_time=time();
            $Model->deadline=$active['deadline'];
            $Model->add();
            echo '申请活动成功';


        }

    }

}