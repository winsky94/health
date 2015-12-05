function write_quick_back_button() {
    var text = '\
        <div id="quick-back_button"></div>\
        <div class="col s12 l1" id="content-on-right">\
            <p id="back-to-top" style="position:fixed;bottom:0">\
                <a href="#top">\
                    <i class="large grey-text mdi-hardware-keyboard-arrow-up"></i>\
                </a>\
            </p>\
        </div>\
    ';
    $("#back-up").html(text);

    // 具体解释的注释看userInfo.php文件的注释
    var txt = '\
		<script> \
			$(document).ready(function () { \
            $("#back-to-top").hide(); \
            $(function () { \
                $(window).scroll(function () { \
                    if ($(window).scrollTop() > 100) { \
                        $("#back-to-top").fadeIn(1500); \
                    } \
                    else { \
                        $("#back-to-top").fadeOut(1500); \
                    } \
                }); \
                $("#back-to-top").click(function () { \
                    $("body,html").animate({scrollTop: 0}, 1000); \
                    return false; \
                }); \
            }); \
        }); \
		</script>';
    $("#quick-back_button").html(txt);

}


function write_user_info(user_info) {
    var userName = user_info.getElementsByTagName("userName")[0].firstChild.nodeValue;
    var sex = user_info.getElementsByTagName("sex")[0].firstChild.nodeValue;
    var age = user_info.getElementsByTagName("age")[0].firstChild.nodeValue;
    var height = user_info.getElementsByTagName("height")[0].firstChild.nodeValue;
    var weight = user_info.getElementsByTagName("weight")[0].firstChild.nodeValue;
    var telephone = user_info.getElementsByTagName("telephone")[0].firstChild.nodeValue;
    var email = user_info.getElementsByTagName("email")[0].firstChild.nodeValue;

    var txt = '<div class="card grey lighten-3"> \
                <div class="card-content" id="user-info-container">  \
                    <div class="table-row"> \
                        <div class="property">昵　称：</div> \
                        <div class="value" id="userName">' + userName + '</div> \
                    </div> \
                    <div class="table-row"> \
                        <div class="property">性　别：</div> \
                        <div class="value" id="sex">' + sex + '</div> \
                    </div> \
                    <div class="table-row"> \
                        <div class="property">年　龄：</div> \
                        <div class="value" id="age">' + age + '</div> \
                    </div> \
                    <div class="table-row"> \
                        <div class="property">身　高：</div> \
                        <div class="value" id="height">' + height + '</div> \
                    </div> \
                    <div class="table-row"> \
                        <div class="property">体　重：</div> \
                        <div class="value" id="weight">' + weight + '</div> \
                    </div> \
                    <div class="table-row"> \
                        <div class="property">电　话：</div> \
                        <div class="value" id="telephone">' + telephone + '</div> \
                    </div> \
                    <div class="table-row"> \
                        <div class="property">邮　箱：</div> \
                        <div class="value" id="email">' + email + '</div> \
                    </div> \
                    <div class="card-action"> \
                        <a href="#" onclick="write_edit_user_info()">编辑</a> \
                        <a href="#" onclick="write_changepw()">修改密码</a> \
                    </div> \
                </div> \
            </div>';
    return txt;

}

function write_edit_user_info() {
    var userName = $("#userName").html();
    var sex=$("#sex").html();
    var age=$("#age").html();
    var height=$("#height").html();
    var weight=$("#weight").html();
    var telephone=$("#telephone").html();
    var email = $("#email").html();

    var txt = '\
        <style type="text/css"> \
            .table-container{ \
                display: table; \
                border-spacing: 10px; \
            } \
            .row-container{ \
                display: table-row;  \
            } \
            .cell{ \
                display: table-cell; \
            } \
        </style> \
        <div class="input-field col s12">  \
            <input disabled id="userName" type="text" name="userName" value="' + userName + '"> \
            <label for="userName" class="active">昵　称：</label>  \
        </div> \
        <div class="input-field col s12">  \
            <input id="sex" type="text" name="sex" value="' + sex + '"> \
            <label for="sex" class="active">性　别：</label>  \
        </div> \
        <div class="input-field col s12">  \
            <input id="age" type="text" name="age" value="' + age + '"> \
            <label for="age" class="active">年　龄：</label>  \
        </div> \
        <div class="input-field col s12">  \
            <input id="height" type="text" name="height" value="' + height + '"> \
            <label for="height" class="active">身　高：</label>  \
        </div> \
        <div class="input-field col s12">  \
            <input id="weight" type="text" name="weight" value="' + weight + '"> \
            <label for="weight" class="active">体　重：</label>  \
        </div> \
        <div class="input-field col s12">  \
            <input id="telephone" type="text" name="telephone" value="' + telephone + '"> \
            <label for="telephone" class="active">电　话：</label>  \
        </div> \
        <div class="input-field col s12">  \
            <input id="email" type="email" name="email" class="validate" value="' + email + '">  \
            <label for="email" class="active">邮　箱：</label>  \
        </div>  \
        <div class="col s8 table-container"> \
            <div class="row-container"> \
            <div class="input-field cell">  \
                <input id="flag" type="hidden" name="flag" value="userinfo"> \
                <input type="submit" value="保存" onclick="verify_change_user_info()" class="btn btn-primary">  \
            </div>  \
            <a class="btn btn-primary" onclick="window.location.reload(true)">取消</a> \
            <div class="input-field cell"> \
            	<font color="red" size="3"><span id="result" style="margin-left: 100px;"></span></font> \
            </div> \
        </div> \
    </div>';
    $("#user-info-container").html(txt);
}

function write_changepw() {
    var userName = $("#userName").html();
    var txt = '<style type="text/css"> \
        .table-container{ \
            display: table; \
            border-spacing: 10px; \
        } \
        .row-container{ \
            display: table-row;  \
        } \
        .cell{ \
            display: table-cell; \
        } \
    </style> \
                <div class="input-field col s12"> \
                    <input disabled type="text" id="userName" name="userName" class="validate" value="' + userName + '"> \
                    <label for="userName" class="active">Nickname</label> \
                </div> \
                <div class="input-field col s12"> \
                    <input id="password" type="password" name="password" class="validate"> \
                    <label for="password">当前密码:</label> \
                </div> \
                <div class="input-field col s12"> \
                    <input id="newPassword" type="password" name="newPassword" class="validate"> \
                    <label for="newPassword">修改密码:</label> \
                </div> \
                <div class="input-field col s12"> \
                    <input id="confirmPassword" type="password" name="confirmPassword" class="validate"> \
                    <label for="confirmPassword">确认密码:</label> \
                </div> \
                <div class="col s12 table-container"> \
                    <div class="row row-container"> \
                        <div class="input-field cell"> \
                            <input type="hidden" id="flag" name="flag" value="password"> \
                            <input type="submit" value="提交" onclick="verify_changepw()" class="btn btn-primary"> \
                        </div> \
                        <a class="btn btn-primary" onclick="window.location.reload(true)">取消</a> \
                        <div class="input-field cell">  \
                            <font color="red" size="3"><span id="result" style="margin-left: 100px;"></span></font>  \
                        </div> \
                    </div> \
            </div>';
    $("#user-info-container").html(txt);
}

function write_footer() {
    var txt = '<footer class="page-footer teal lighten-2"> \
        <div class="footer-copyright"> \
            <div class="container"> \
                © 2015 winsky,software institute, NJU <a \
                    class="grey-text text-lighten-4 right" href="http://www.hao123.com">联系我们</a> \
            </div> \
        </div> \
            </footer>';
    $("#footer").html(txt);
}

function write_pagination(start, end, active_num, page_num) {
    var txt;
    if (start == 1 && active_num == 1) {
        txt = '<li class="disabled"> \
                <a onclick="return false;">  \
                    <i class="mdi-navigation-chevron-left"></i> \
                </a> \
            </li>';
    } else {
        txt = '<li class="waves-effect"> \
                <a onclick="page_up(active_num);return false;">  \
                    <i class="mdi-navigation-chevron-left"></i> \
                </a> \
            </li>';
    }


    for (i = start; i <= end; i++) {
        if (i == active_num) {
            txt = txt + '<li class="active" title="' + i + '"> \
                        <a onclick="return false;">' + i + '</a> \
                    </li>';
        } else {
            txt = txt + '<li class="waves-effect" title="' + i + ' " onclick="turn_to_page(this.title);scrollTo(0,0);return false;"> \
                        <a>' + i + '</a> \
                    </li>';
        }
    }

    if (end == page_num && active_num == page_num) {
        txt = txt + '<li class="disabled"> \
                <a onclick="return false;"> \
                    <i class="mdi-navigation-chevron-right"></i> \
                </a> \
             </li>';
    } else {
        txt = txt + '<li class="waves-effect"> \
                <a onclick="page_down(active_num);scrollTo(0,0);return false;"> \
                    <i class="mdi-navigation-chevron-right"></i> \
                </a> \
             </li>';
    }

    $(".pagination").html(txt);
}

function write_event_list(events) {
    var txt = '';
    for (var i = 0; i < events.length; i++) {
        var event = events[i];
        var name = event.getElementsByTagName("name")[0].firstChild.nodeValue;
        var introduction = event.getElementsByTagName("introduction")[0].firstChild.nodeValue;
        var startDate = event.getElementsByTagName("startDate")[0].firstChild.nodeValue;
        var endDate = event.getElementsByTagName("endDate")[0].firstChild.nodeValue;
        var detail = event.getElementsByTagName("detail")[0].firstChild.nodeValue;
        var peopleNum = event.getElementsByTagName("peopleNum")[0].firstChild.nodeValue;
        var state = event.getElementsByTagName("state")[0].firstChild.nodeValue;
        txt += '<div class="row">\
                <div style="height: 100px;overflow:hidden;">\
                    <div class="action_content float_left">\
                        <div class="act_c_d float_left">\
                            <div class="blank10"></div>\
                            <div style="min-height: 30px;">\
                                <a class="font16" style="font-weight:bold;" href="#" title=' + name + ' onclick="joinEvent(title);">' + name + '\
                                </a>\
                                <a  href="#" title=' + name + ' onclick="deleteEvent(title)" class="font16" style="float: right;">删除</a>\
                                <span></span>\
                                <a  href="#" title=' + name + ' onclick="updateEvent(title)" class="font16" style="float: right;">修改&nbsp;&nbsp;&nbsp;</a>\
                            </div>\
                            <div>\
                                开始日期：<span style="font-weight: 900">' + startDate + '</span>\
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                                结束日期：<span style="font-weight: 900">' + endDate + '</span>\
                            </div>\
                            <div class="blank10"></div>\
                            <div class="font12">\
                                ' + introduction + '\
                            </div>\
                        </div>\
                        <div class="action_num_state">\
                            <div class="proceed_1"\
                                style="text-align:center;font-weight:bold;line-height: 60px;">\
                                ' + state + '\
                            </div>\
                            <div style="text-align:center;">\
                                ' + peopleNum + '人参与\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>';
    }

    return txt;
}

function write_suggestion_list(suggestions) {
    var txt = '';
    for (var i = 0; i < suggestions.length; i++) {
        var suggestion = suggestions[i];
        var title = suggestion.getElementsByTagName("title")[0].firstChild.nodeValue;
        var content = suggestion.getElementsByTagName("content")[0].firstChild.nodeValue;
        var author = suggestion.getElementsByTagName("author")[0].firstChild.nodeValue;
        var type = suggestion.getElementsByTagName("type")[0].firstChild.nodeValue;
        var email = suggestion.getElementsByTagName("email")[0].firstChild.nodeValue;
        var telephone = suggestion.getElementsByTagName("telephone")[0].firstChild.nodeValue;
        var time = suggestion.getElementsByTagName("time")[0].firstChild.nodeValue;

        txt += '<li class="collection-item avatar">\
            <img src="../images/back1.jpg" class="circle">\
            <span class="title" style="font-weight: bold;">' + title + '</span>\
            <p style="font-family: 微软雅黑;margin-left: 50px">\
                发布者：' + author + '\
                <span style="margin-left: 20px">' + time + '</span>\
            </p>\
        <p style="text-indent: 2ex;">\
            ' + content + '\
        </p>\
        </li>\
        ';
    }

    return txt;
}

function write_users_list(users) {
    var txt = '';

    for (var i = 0; i < users.length; i++) {
        var user = users[i];
        var name = user.getElementsByTagName("name")[0].firstChild.nodeValue;
        var sex = user.getElementsByTagName("sex")[0].firstChild.nodeValue;
        var age = user.getElementsByTagName("age")[0].firstChild.nodeValue;
        var lastLoadTime = user.getElementsByTagName("lastLoadTime")[0].firstChild.nodeValue;
        txt += '<div class="row">\
                <div style="height: 100px;overflow:hidden;">\
                    <div class="action_content float_left">\
                        <div class="act_c_d float_left">\
                            <div class="blank10"></div>\
                            <div style="min-height: 30px;">\
                                <a class="font16" style="font-weight:bold;" href="#" title=' + name + ' onclick="makeFriends(title);">' + name + '\
                                </a>\
                            </div>\
                            <div>\
                                性别：<span style="font-weight: 900">' + sex + '</span>\
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                                年龄：<span style="font-weight: 900">' + age + '</span>\
                            </div>\
                            <div class="blank10"></div>\
                            <div class="font16">\
                                上次登录：<span style="font-weight: 900">' + lastLoadTime + '</span>\
                            </div>\
                        </div>\
                        <div class="action_num_state">\
                            <div style="text-align:center;margin-top:40px;">\
                               <a class="font16" style="font-weight: bold" href="#" title=' + name + ' onclick="makeFriends(title);">关注</a>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>';
    }

    return txt;
}

function write_friends_list(users) {
    var txt = '';

    for (var i = 0; i < users.length; i++) {
        var user = users[i];
        var name = user.getElementsByTagName("name")[0].firstChild.nodeValue;
        var sex = user.getElementsByTagName("sex")[0].firstChild.nodeValue;
        var age = user.getElementsByTagName("age")[0].firstChild.nodeValue;
        var lastLoadTime = user.getElementsByTagName("lastLoadTime")[0].firstChild.nodeValue;
        txt += '<div class="row">\
                <div style="height: 100px;overflow:hidden;">\
                    <div class="action_content float_left">\
                        <div class="act_c_d float_left">\
                            <div class="blank10"></div>\
                            <div style="min-height: 30px;">\
                                <a class="font16" style="font-weight:bold;" href="#" title=' + name + ' onclick="makeFriends(title);">' + name + '\
                                </a>\
                            </div>\
                            <div>\
                                性别：<span style="font-weight: 900">' + sex + '</span>\
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                                年龄：<span style="font-weight: 900">' + age + '</span>\
                            </div>\
                            <div class="blank10"></div>\
                            <div class="font16">\
                                上次登录：<span style="font-weight: 900">' + lastLoadTime + '</span>\
                            </div>\
                        </div>\
                        <div class="action_num_state">\
                            <div style="text-align:center;margin-top:40px;">\
                               <a href="../view/userInfo.php?userName=' + name + '" class="font16" style="font-weight: bold">查看详情</a>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>';
    }

    return txt;
}
