/**
 * Created by Administrator on 2015/12/2.
 */
// 路径配置
var myChart = "";
require.config({
    paths: {
        echarts: '../eChart-2.2.7/build/dist'
    }
});

// 使用
require(
    [
        'echarts',
        'echarts/chart/bar',// 使用柱状图就加载bar模块，按需加载
        'echarts/chart/line' // 使用柱状图就加载折线图模块，按需加载
    ],
    getData
);

function getData(ec) {
    //var date = document.getElementById("date").value;
    var userName = document.getElementById("userName").value;
    var date = "今天";
    if (date == "今天") {
        date = getNowFormatDate();
    }

    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            on_data_response(xmlHttp, ec, date)
        };
        xmlHttp.open("POST", "../controller/healthHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("date=" + date + "&userName=" + userName);

    }
}

function on_data_response(xmlHttp, ec) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var text = jQuery.parseJSON(xmlHttp.responseText);

        var sports = text.sports;
        var sportData = [sports.data1, sports.data2, sports.data3, sports.data4, sports.data5, sports.data6, sports.data7];
        var dates = text.dates;
        var dateData = [dates.date1, dates.date2, dates.date3, dates.date4, dates.date5, dates.date6, dates.date7]

        setOption(sportData, dateData, ec);
    }
}

function setOption(sportData, dateData, ec) {
    // 基于准备好的dom，初始化eCharts图表
    myChart = ec.init(document.getElementById('main'));

    var option = {
        title: {
            text: '运动历史',
            //subtext: '纯属虚构'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['运动距离']
        },
        toolbox: {
            show: true,
            feature: {
                mark: {show: true},
                dataView: {show: true, readOnly: false},
                magicType: {show: true, type: ['line', 'bar']},
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        calculable: true,
        xAxis: [
            {
                type: 'category',
                boundaryGap: false,
                data: dateData
            }
        ],
        yAxis: [
            {
                type: 'value',
                axisLabel: {
                    formatter: '{value} 公里'
                }
            }
        ],
        series: [
            {
                name: '运动距离',
                type: 'line',
                data: sportData,
                markPoint: {
                    data: [
                        {type: 'max', name: '最大值'},
                        {type: 'min', name: '最小值'}
                    ]
                },
                markLine: {
                    data: [
                        {type: 'average', name: '平均值'}
                    ]
                }
            }
        ]
    };

    // 为echarts对象加载数据
    myChart.setOption(option);
}

function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentDate = date.getFullYear() + seperator1 + month + seperator1 + strDate
        + " " + date.getHours() + seperator2 + date.getMinutes()
        + seperator2 + date.getSeconds();
    return currentDate;
}
