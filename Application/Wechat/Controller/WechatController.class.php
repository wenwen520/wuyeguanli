<?php
namespace Wechat\Controller;
use Think\Controller;

class WechatController extends Controller{


    //显示首页
    public function index(){
        //加载视图
        $this->buildHtml('index', HTML_PATH . '/news/', 'index');
        $this->display('index');
    }



    //租售列表
    public function rental(){

        $list=M('rental')->where("type=0")->select();//出租的房子
        $sale=M('rental')->where("type=1")->select();//出售的房子
        $this->assign('list', $list);
        $this->assign('sale', $sale);
        $this->display('rental');
    }


    //租售的详情
    public function rental_detail($id){
        $detail=M('rental')->find($id);
        $this->assign('detail',$detail);
        $this->display('rental_detail');

    }


    //小区通知
    public function notice(){
        $model=M('document');
        $notice = $model
            ->join('onethink_picture ON onethink_picture.id=onethink_document.cover_id')
            ->join('onethink_document_article ON onethink_document_article.id=onethink_document.id ')
            ->select();
        $this->assign('notice',$notice);
//        var_dump($notice);exit;
        $this->display('notice');

    }

//    //小区通知详情
    public function notice_detail($notice_id){
//        var_dump($notice_id);exit;
        $notice=M('document_article')->find($notice_id);
        $document = M('document')->find($notice_id);
        $this->assign('notice',$notice);
        $this->assign('document',$document);
        $this->display('notice_detail');
    }

}