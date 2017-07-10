<?php
namespace Admin\Model;

use Think\Model;

class XqhdModel extends Model{


    protected $_validate = array(
        array('name', 'require', '姓名不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),


    );
    protected $_auto = array(
        array('status', '1', self::MODEL_INSERT),
        array('category_id','43',self::MODEL_INSERT),
        array('start_time', NOW_TIME, self::MODEL_INSERT),
    );


}