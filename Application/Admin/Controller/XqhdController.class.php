<?php
namespace Admin\Controller;

use Think\Controller;

class XqhdController extends Controller{


    //小区活动
    public function community_activity(){
        $activity=M('document')->where('category_id=43')->select();

        $this->assign('activity',$activity);
        $this->display('community_activity');

    }

    //发布活动
    public function release($id){
        $Model=M('document');
        $active=$Model->where(['id='.$id])->find();
        $Model->where(['id='.$id])->save(['status'=>2]);

    }

    //添加活动
    public function add(){
        if(IS_POST){
            $Rental = D('Document');//实例化模型对象
            $data = $Rental->create();//调用模型上的新增方法
            if($data){
                $id = $Rental->add();
                if($id){
                    $this->success('新增成功', U('index'));//新增成功 跳转到index
                    //记录行为
                    action_log('update_rental', 'Document', $id, UID);
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Rental->getError());
            }
        } else {

            $this->display('add');//显示页面
        }
    }




}