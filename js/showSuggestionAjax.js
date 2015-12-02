/**
 * Created by Administrator on 2015/11/28.
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
    get_suggestions(active_num);
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
    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            on_page_num_response(xmlHttp)
        };
        xmlHttp.open("POST", "../controller/SuggestionHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=getSuggestionsPageNum");

    }
}

function on_page_num_response(xmlHttp) {
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
        get_suggestions(1);  //请求第一页
    }
}

function get_suggestions(current_page) {
    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.open('POST', '../controller/SuggestionHandle.php');
        xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlHttp.onreadystatechange = function () {
            onSuggestionsResponse(xmlHttp)
        };
        xmlHttp.send("action=getSuggestions&pageNum=" + current_page);
    } else {
        alert('Your browser does not support XMLHttpRequest.');
    }
}

function onSuggestionsResponse(xmlHttp) {
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
        var file_elements = xmlDoc.getElementsByTagName("suggestion");
        var txt = write_suggestion_list(file_elements);
        $("#suggestions_list").html(txt);
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
    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            onSearchResponse(xmlHttp)
        };

        xmlHttp.open("POST", "../controller/SuggestionHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=search" + "&type=" + type + "&keyword=" + keyword);

    } else {
        alert("Your browser does not support XMLHttpRequest");
    }
}

function onSearchResponse(xmlHttp) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
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
        var file_elements = xmlDoc.getElementsByTagName("suggestion");
        var txt = write_suggestion_list(file_elements);
        $("#suggestions_list").html(txt);
    }
}