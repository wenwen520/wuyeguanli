<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/Public/Wechat/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Wechat/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>
</head>
<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="index.html" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid" id="content_list">
        <?php if(is_array($shop)): $i = 0; $__LIST__ = $shop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shop): $mod = ($i % 2 );++$i;?><div class="row noticeList">
            <a href="<?php echo U('Wechat/shop_detail',array('shop_id'=>$shop['id'],'view'=>$shop['view']));?>">
            <div class="col-xs-2">
               <img src="<?php echo ($shop["path"]); ?>">
            </div>
            <div class="col-xs-10">
                <p class="title"><?php echo ($shop["title"]); ?></p>
                <p class="intro"><?php echo ($shop["description"]); ?></p>
                <p class="info">浏览: 199 <span class="pull-right"><?php echo date('Y-m-d G:i:s',$shop['create_time']);?></span> </p>
            </div>
            </a>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>

    </div>
    <div class="text-center">
        <button type="button" class="btn btn-info ajax-page">获取更多~</button>

    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/Public/Wechat/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/Public/Wechat/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>


<script type="text/javascript" src="/Public/Wechat/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="/Public/Wechat/bootstrap/js/bootstrap.min.js"></script>
<script type="application/javascript">





    var p = 0;
    var url = '/wchat.php?s=/Wechat/Wechat/shop_activity';
    var inner_url = '/wchat.php?s=/Shop/detail';
    var html='';


    $(function(){
        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
        }

        $('.ajax-page').click(function () {
            if($(this).hasClass('ajax-page')){
                p = p+1;
                $.get(url+'/p/'+p,function(data){

                    if(data!=null){

                        $(data).each((function(i,v){
//                            <a href="<?php echo U('Wechat/shop_detail?shop_id='.$shop['id']);?>">
                            html += '<div class="row noticeList">\
                                            \
                                                <div class="col-xs-2">\
                                                <a href="shop_detail/shop_id/'+v.id+'">\
                                                    <img class="img-rounded img-responsive" src="'+ v.path+'" />\
                                                </div>\
                                                <div class="col-xs-10">\
                                                    <p class="title"><a href="shop_detail/shop_id/'+v.id+'">'+v.title+'</a></p>\
                                                    <p class="intro">'+ v.description+'</p>\
                                                    <p class="info">浏览: '+ v.view+' <span class="pull-right">'+getLocalTime(v.create_time)+'</span> </p>\
                                                </div>\
                                            </a>\
                                        </div>';
//                            console.log(html);return;
                            $('#content_list').append(html);
                        }))
                    }else {
                        $('.ajax-page').remove();//没有数据了删除按钮
                    }
                })
            }
        });

    });
</script>