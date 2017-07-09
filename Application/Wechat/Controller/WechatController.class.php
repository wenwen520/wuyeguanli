<?php
namespace Wechat\Controller;
use Think\Controller;
use Think\Page;

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
            ->where('category_id=40')
            ->select();
        $this->assign('notice',$notice);
//        var_dump($notice);exit;
        $this->display('notice');

    }

//    //小区通知详情
    public function notice_detail($notice_id,$view){
        $model=M('document');
        $document = $model->where('id='.$notice_id)->find();
        $model->where('id='.$notice_id)->save(['view'=>$view+1]);
        $notice=M('document_article')->find($notice_id);
        $this->assign('notice',$notice);
        $this->assign('document',$document);
        $this->display('notice_detail');
    }


    //商家活动
    public function shop_activity(){

        $Model=M('document');
        $shop=$Model
            ->join('onethink_picture ON onethink_document.cover_id=onethink_picture.id')
            ->join('onethink_document_article ON onethink_document_article.id=onethink_document.id')
            ->where('category_id=41 AND deadline<'.time())
            ->select();
        $this->assign('shop',$shop);
        $this->display('shop_activity');
    }

    //商家活动详情
    public function shop_detail($shop_id){
        $detail = M('document_article')->find($shop_id);
        $activity = M('document')->find($shop_id);
        $this->assign('detail',$detail);
        $this->assign('activity',$activity);
        $this->display('shop_detail');

    }


    //便民服务
    public function service(){
        $Model=M('document');

        $service=$Model
            ->join('onethink_picture ON onethink_document.cover_id = onethink_picture.id')
            ->join('onethink_document_article ON onethink_document_article.id=onethink_document.id')
            ->where('category_id=42')
            ->select();
        $this->assign('service',$service);
        $this->display('service');
    }

    //服务详情
    public function service_detail($service_id){
        $service = M('document')->find($service_id);
        $detail = M('document_article')->find($service_id);
        $this->assign('service',$service);
        $this->assign('detail',$detail);
        $this->display('service_detail');
    }


}