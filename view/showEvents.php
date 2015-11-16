<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>查看活动</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/showEvents.css" type="text/css" rel="stylesheet" media="screen,projection"/>


</head>
<body onload="write_header();write_footer();write_quick_back_button();" id="top">
<header></header>

<div class="main container">
    <br>

    <div class="row">
        <!--左侧动态消息播报-->
        <div class="col s12 l3" id="content-left">
            <!--<div class="blank20" style="height:20px;clear:both;font-size:0px;overflow:hidden;"></div>-->
            <script type="text/javascript" src="../js/scrollText.js"></script>
            <div class="incubate_des font12">
                <div class="blank5" style="height:5px;clear:both;font-size:0px;overflow:hidden;"></div>
                <div class="inner">
                    <div class="blank10" style="height:10px;clear:both;font-size:0px;overflow:hidden;"></div>
                    <h3>最新消息</h3>

                    <div style="overflow: hidden; height: 247px; width: 226px; position:relative;">

                        <ul id="jsFoot" class="noticTipTxt float_left" style="font-size: 14px;line-height: 20px;">

                            <li>【阳光奔跑 跬步大爱】@千渡 获得了咕咚手环2 08-25 00:00</li>

                            <li>【阳光奔跑 跬步大爱】@c2NHuqzuser 获得了咕咚手环2 08-24 00:00</li>

                            <li>【阳光奔跑 跬步大爱】@浅草妖姬 获得了咕咚手环2 08-20 00:00</li>

                            <li>【阳光奔跑 跬步大爱】@鱼的石头 获得了金龙鱼阳光葵花籽油 08-20 00:00</li>

                            <li>【阳光奔跑 跬步大爱】@雪山非狐0828 获得了咕咚手环2 08-19 00:00</li>

                            <li>【阳光奔跑 跬步大爱】@HXY猴哥 获得了金龙鱼阳光葵花籽油 08-15 00:00</li>

                            <li>【阳光奔跑 跬步大爱】@煙钬 获得了金龙鱼阳光葵花籽油 08-14 00:00</li>

                            <li>【阳光奔跑 跬步大爱】@踏浪---东 获得了金龙鱼阳光葵花籽油 08-13 00:00</li>

                            <li>【阳光奔跑 跬步大爱】@华丽的大卫 获得了金龙鱼阳光葵花籽油 08-12 00:00</li>

                            <li>【阳光奔跑 跬步大爱】@蝈蝈蝈傲 获得了金龙鱼阳光葵花籽油 08-11 00:00</li>

                        </ul>

                    </div>
                </div>
                <div class="blank5" style="height:5px;clear:both;font-size:0px;overflow:hidden;"></div>
            </div>

        </div>
        <!--左侧动态消息播报结束-->

        <!--中间活动列表-->
        <div class="col s12 l8" id="content-on-middle">
            <div style="margin-left: 20px;">
                <div class="font16">最新活动</div>
                <div class="blank10"></div>

                <div id="events_list"></div>

                <!-- 页数导航 -->
                <br>

                <div class="pagination" style="text-align: center">
                </div>

            </div>
        </div>
        <!--中间活动列表结束-->

        <!--右侧快速返回顶部-->
        <div id="back-up"></div>
        <!--右侧快速返回顶部结束-->

    </div>
    <!--12列结束-->
</div>


<div id="footer"></div>

<!--  javaScripts -->
<script src="../js/jquery-2.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/cookie.js"></script>
<script src="../js/writeHTML.js"></script>
<script src="../js/xmlhttp.js"></script>
<script type="text/javascript" src="../js/LoginAjax.js"></script>
<script src="../js/jQuery.js"></script>
<script src="../js/ChangeUserInfoAjax.js"></script>
<script src="../js/ChangePWAjax.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/LoginAjax.js"></script>
<script src="../js/eventAjax.js"></script>
<script>
    var jQ = jQuery.noConflict();
    var $ = jQ;
</script>

<!--显示页码-->
<script>
    get_page_num();
</script>

<!-- 滚动显示 -->
<script type="text/javascript" src="../js/TweenMax.min.js"></script>
<script type="text/javascript">
    $(window).load(function () {
        runList();
    });
    function runList() {
        var _dom = jQ(".noticTipTxt");
        var content_html = _dom.find("li").eq(0).html();
        var _top = _dom.find("li").eq(1).height();
        var _html = "<li>" + content_html + "</li>";
        TweenMax.to(_dom, 3, {css: {top: (0 - _top - 10)}, ease: Cubic.easeOut, onComplete: runList});
        _dom.append(_html);
        _dom.find("li").eq(0).remove();
        _dom.css("top", "0px");
    }
</script>

</body>
</html>