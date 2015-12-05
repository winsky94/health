/**
 * Created by Administrator on 2015/12/5.
 */
var page_num = 1;
var start = 1;
var end = 1;
var active_num = 1;

function turn_to_page(select_page) {
    active_num = parseInt(select_page);

    if (active_num - 2 >= 1 && active_num + 2 <= page_num) {
        start = active_num - 2;
        end = active_num + 2;
    } else if (active_num - 2 < 1) {
        start = 1;
        end = start + 4;
    } else {
        start = page_num - 4;
        end = page_num;
    }

    write_pagination(start, end, active_num, page_num);
    get_users(active_num);
}

function page_up(current_page) {
    if (current_page > 1) {
        turn_to_page(current_page - 1);
    }
}

function page_down(current_page) {
    if (current_page < page_num) {
        turn_to_page(current_page + 1);
    }
}

function get_user_page_num() {
    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            on_user_page_response(xmlHttp)
        };
        xmlHttp.open("POST", "../controller/FriendHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=getUsersPageNum");

    }
}

function on_user_page_response(xmlHttp) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        page_num = xmlHttp.responseText;
        if (page_num <= 5) {
            start = 1;
            end = page_num;
        } else {
            start = 1;
            end = 5;
        }
        active_num = 1;
        write_pagination(start, end, active_num, page_num);	 //初始化页码
        get_users(1);  //请求第一页
    }
}

function get_users(current_page) {
    var xmlhttp = getXmlHttp();
    if (xmlhttp != null) {
        xmlhttp.open('POST', '../controller/FriendHandle.php');
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.onreadystatechange = function () {
            onUsersResponse(xmlhttp)
        };
        xmlhttp.send("action=getUsers&pageNum=" + current_page);
    } else {
        alert('Your browser does not support XMLHttpRequest.');
    }
}

function onUsersResponse(xmlHttp) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        //file_elements是一个数组
        var text = xmlHttp.responseText;
        try {
            var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.async = "false";
            xmlDoc.loadXML(text);
        } catch (e) {
            try {
                var parser = new DOMParser();
                xmlDoc = parser.parseFromString(text, "text/xml");
            } catch (e) {
                alert(e.message);
            }
        }
        var file_elements = xmlDoc.getElementsByTagName("user");
        var txt = write_users_list(file_elements);
        $("#users_list").html(txt);
    }
}

function makeFriends(friend) {
    var name = document.getElementById("login_user").innerText;
    if (name == friend) {
        alert("不能关注自己噢~");
        return;
    }
    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            onMakeFriendsResponse(xmlHttp, friend)
        };
        xmlHttp.open("POST", "../controller/FriendHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=makeFriends" + "&name=" + name + "&friend=" + friend);

    }
}

function onMakeFriendsResponse(xmlHttp, friend) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var result = xmlHttp.responseText;
        if (result == true) {
            location.reload();
        } else {
            alert("您已关注过“ " + friend + " ”， 不能重复关注");
        }
    } else {
    }
}

//=================================================================================================
//朋友

function get_friend_page_num() {
    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            on_friend_page_response(xmlHttp)
        };
        xmlHttp.open("POST", "../controller/FriendHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=getFriendsPageNum");

    }
}

function on_friend_page_response(xmlHttp) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        page_num = xmlHttp.responseText;
        if (page_num <= 5) {
            start = 1;
            end = page_num;
        } else {
            start = 1;
            end = 5;
        }
        active_num = 1;
        write_pagination(start, end, active_num, page_num);	 //初始化页码
        get_friends(1);  //请求第一页
    }
}
function get_friends(current_page) {
    var xmlHttp = getXmlHttp();
    var name = document.getElementById("login_user").innerText;
    if (xmlHttp != null) {
        xmlHttp.open('POST', '../controller/FriendHandle.php');
        xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlHttp.onreadystatechange = function () {
            onFriendsResponse(xmlHttp)
        };
        xmlHttp.send("action=getFriends&pageNum=" + current_page + "&name=" + name);
    } else {
        alert('Your browser does not support XMLHttpRequest.');
    }
}

function onFriendsResponse(xmlHttp) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        //file_elements是一个数组
        var text = xmlHttp.responseText;
        try {
            var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.async = "false";
            xmlDoc.loadXML(text);
        } catch (e) {
            try {
                var parser = new DOMParser();
                xmlDoc = parser.parseFromString(text, "text/xml");
            } catch (e) {
                alert(e.message);
            }
        }
        var file_elements = xmlDoc.getElementsByTagName("friend");
        var txt = write_friends_list(file_elements);
        $("#friends_list").html(txt);
    }
}

