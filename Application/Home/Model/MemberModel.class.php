<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;
use User\Api\UserApi;

/**
 * 文档基础模型
 */
class MemberModel extends Model{

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('login', 0, self::MODEL_INSERT),
        array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
        array('reg_time', NOW_TIME, self::MODEL_INSERT),
        array('last_login_ip', 0, self::MODEL_INSERT),
        array('last_login_time', 0, self::MODEL_INSERT),
        array('status', 1, self::MODEL_INSERT),
    );

    /**
     * 登录指定用户
     * @param  integer $uid 用户ID
     * @return boolean      ture-登录成功，false-登录失败
     */
    public function register($uid){
        /* 检测是否在当前应用注册 */
        $user = $this->field(true)->find($uid);
        if(!$user){ //未注册
            /* 在当前应用中注册用户 */
        	$Api = new UserApi();
        	$info = $Api->info($uid);
            $user = $this->create(array('nickname' => $info[1], 'status' => 1));
            $user['uid'] = $uid;
            if(!$this->add($user)){
                $this->error = '前台用户信息注册失败，请重试！';
                return false;
            }
        } elseif(1 != $user['status']) {
            $this->error = '用户未激活或已禁用！'; //应用级别禁用

            return false;
        }

        /* 登录用户 */
        $this->autoLogin($user);

        //记录行为
        action_log('user_login', 'member', $uid, $uid);

        return true;
    }

    /**
     * 注销当前用户
     * @return void
     */
    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){
        /* 更新登录信息 */
        $data = array(
            'uid'             => $user['uid'],
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip'   => get_client_ip(1),
        );
        $this->save($data);

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['uid'],
            'username'        => get_username($user['uid']),
            'last_login_time' => $user['last_login_time'],
        );

        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));

    }
//    /* 登录页面 */
//    public function login($username = '', $password = '', $verify = ''){
//        if(IS_POST){ //登录验证
//            /* 检测验证码 */
//            if(!check_verify($verify)){
//                $this->error('验证码输入错误！');
//            }
//
//            /* 调用UC登录接口登录 */
//            $user = new UserApi;
//            $uid = $user->login($username, $password);
//            if(0 < $uid){ //UC登录成功
//                /* 登录用户 */
//                $Member = D('Member');
//                if($Member->login($uid)){ //登录用户
//                    //TODO:跳转到登录前页面
//                    $this->success('登录成功！',U('Wechat/Wechat/index'));
//                } else {
//                    $this->error($Member->getError());
//                }
//
//            } else { //登录失败
//                switch($uid) {
//                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
//                    case -2: $error = '密码错误！'; break;
//                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
//                }
//                $this->error($error);
//            }
//
//        } else { //显示登录表单
//            $this->buildHtml('login', HTML_PATH . '/news/', 'login');
//            $this->display();
//        }
//    }

}
