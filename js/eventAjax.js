/**
 * Created by Administrator on 2015/11/14.
 */
var page_num = 1;
var start = 1;
var end = 1;
var active_num = 1;

function turn_to_page(select_page) {
    alert(select_page);
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
    //get_documents_by_course(department, course, active_num);
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

function get_page_num() {
    var xmlhttp = getXmlHttp();
    if (xmlhttp != null) {
        xmlhttp.onreadystatechange = function () {
            on_page_num_response(xmlhttp)
        };
        xmlhttp.open("POST", "../controller/EventHandle.php");
        //post方式需要自己设置http的请求头
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlhttp.send("action=getEventsPageNum");

    }
}

function on_page_num_response(xmlhttp) {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        page_num = xmlhttp.responseText;
        if (page_num <= 5) {
            start = 1;
            end = page_num;
        } else {
            start = 1;
            end = 5;
        }
        active_num = 1;
        write_pagination(start, end, active_num, page_num);	 //初始化页码
        //get_documents_by_course(department, course, 1);  //请求第一页
    }
}

function get_course_list(xmlhttp_course) {
    if (xmlhttp_course.readyState == 4 && xmlhttp_course.status == 200) {
        //file_elements是一个数组
        var text = xmlhttp_course.responseText;
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
        var departments = xmlDoc.getElementsByTagName("department");
        var txt = write_course_list(departments, 0);
        $("#course_list").html(txt);
    }
}

function get_documents_by_course(department_chosen, course_chosen, current_page) {
    var school = $('#university-info').attr('title');
    var nickname = $("#user-name").attr("title");
    var xmlhttp = getXmlHttp();
    if (xmlhttp != null) {
        xmlhttp.open('GET', '/UniNote/DocumentOverViewServlet?school=' + school + '&department=' + department_chosen +
            '&course=' + course_chosen + '&nickname=' + nickname + "&page=" + current_page, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.onreadystatechange = function () {
            onResponse(xmlhttp)
        };
        xmlhttp.send();
    } else {
        alert('Your browser does not support XMLHttpRequest.');
    }
}

function onResponse(xmlhttp) {
    alert(xmlhttp);
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        //file_elements是一个数组
        var text = xmlhttp.responseText;
        alert(text);
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
        var file_elements = xmlDoc.getElementsByTagName("document");
        var txt = write_document_list(file_elements);
        $("#filelist").html(txt);
    }
}

function init_left_list() {
    var xmlhttp_course = getXmlHttp();
    var school = $('#university-info').attr('title');
    if (xmlhttp_course != null) {
        xmlhttp_course.open("GET", "/UniNote/CategoryServlet?school=" + encodeURI(encodeURI(school)), true);
        xmlhttp_course.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp_course.onreadystatechange = function () {
            get_course_list(xmlhttp_course)
        };
        xmlhttp_course.send();
    } else {
        alert("Your browser does not support XMLHttpRequest.");
    }
}


function search_function() {
    var keyword = $("input[name='keyword']").val();
    var type;
    var type_radio_pointers = document.querySelectorAll('[name="type"]');
    for (var i = 0; i < type_radio_pointers.length; i++) {
        if (type_radio_pointers[i].checked) {
            type = type_radio_pointers[i].value;
        }
    }
    var nickname;
    var login = check_cookie();
    if (!login) {
        nickname = "undefined";
    } else {
        nickname = get_cookie("username");
    }
    var xmlhttp = getXmlHttp();
    if (xmlhttp != null) {
        xmlhttp.onreadystatechange = function () {
            onSearchResponse(xmlhttp)
        };
        xmlhttp.open("GET", "/UniNote/SearchServlet?keyword=" + keyword + "&type=" + type + "&nickname=" + nickname, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send();
    } else {
        alert("Your browser does not support XMLHttpRequest");
    }
}

function onSearchResponse(xmlhttp) {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var text = xmlhttp.responseText;
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
        var file_elements = xmlDoc.getElementsByTagName("document");
        var txt = write_document_list(file_elements);
        $("#filelist").html(txt);
    }
}