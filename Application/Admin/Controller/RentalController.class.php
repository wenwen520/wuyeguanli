<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 12:42
 */

namespace Admin\Controller;


use Think\Page;

class RentalController extends AdminController
{
    public function index(){
//        //获取小区租售列表
//        $list = M('Rental')->select();
//        $this->assign('list', $list);
//        $this->meta_title = '小区租售';
//
//        $this->display('index');
             $m=M('Rental');
             import('ORG.Util.Page');// 导入分页类
             $count    = $m->count();// 查询满足要求的总记录数
             $page    = new Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数
             $page->setConfig('header','条信息');
             $show = $page->show();// 分页显示输出
             $this->assign('page',$show);// 赋值分页输出
             $list  = $m->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);// 赋值数据集
             $this->display();
    }

    //添加租售情况
    public function add(){
        if(IS_POST){
            $Rental = D('Rental');//实例化模型对象
            $data = $Rental->create();//调用模型上的新增方法
//            var_dump($_POST);exit;
            if($data){
                $id = $Rental->add();
                if($id){
                    $this->success('新增成功', U('index'));//新增成功 跳转到index
                    //记录行为
                    action_log('update_rental', 'Rental', $id, UID);
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


    //修改
    public function edit($id){
        if(IS_POST){
            $Rental = D('Rental');//创建自定义模型  M是基础模型 不需要创建模型 只具备增删改查的功能
            $data = $Rental->create();
            if($data){
                if($Rental->save()){

                    //记录行为
                    action_log('update_rental', 'rental', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Rental->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $data = M('Rental')->find($id);//find查一条数据   select查询所有数据

            if(false === $data){
                $this->$data('获取配置信息错误');
            }
            $this->assign('data', $data);
            $this->display('add');
        }
    }

    //删除
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('Rental')->where($map)->delete()){
            //记录行为
            action_log('update_rental', 'rental', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }






}