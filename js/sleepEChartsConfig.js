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
    var date = document.getElementById("date").value;
    var userName = document.getElementById("userName").value;

    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            on_data_response(xmlHttp, ec, date)
        };
        xmlHttp.open("POST", "../controller/healthHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=detailSleepStatics" + "&date=" + date + "&userName=" + userName);

    }
}

function on_data_response(xmlHttp, ec) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var text = jQuery.parseJSON(xmlHttp.responseText);

        var startTimeData = [];
        var endTimeData = [];
        var scoreData = [];
        var xData = [];

        for (var i = 0; i < text.length; i++) {
            var sleepData = text[i];
            startTimeData[i] = sleepData["startTime"].substr(11, 2);
            endTimeData[i] = sleepData["endTime"].substr(11, 1);
            scoreData[i] = sleepData["score"];
            xData[i] = i + 1;
        }

        setOption(startTimeData, endTimeData, scoreData, xData, ec);
    }
}

function setOption(startTimeData, endTimeData, scoreData, dateData, ec) {
    // 基于准备好的dom，初始化eCharts图表
    if (ec == "") {
        ec = require('echarts');
    }
    myChart = ec.init(document.getElementById('main'));

    var option = {
        title: {
            text: '睡眠历史',
            //subtext: '纯属虚构'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['开始时间', '结束时间', '睡眠得分']
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
                    formatter: '{value} 点'
                }
            }
        ],
        series: [
            {
                name: '开始时间',
                type: 'line',
                data: startTimeData,
                markPoint: {
                    data: [
                        {type: 'max', name: '最大值'},
                        {type: 'min', name: '最小值'}
                    ]
                },
                //markLine: {
                //data: [
                //    {type: 'average', name: '平均值'}
                //]
                //}
            },
            {
                name: '结束时间',
                type: 'line',
                data: endTimeData,
                markPoint: {
                    data: [
                        {type: 'max', name: '最大值'},
                        {type: 'min', name: '最小值'}
                    ]
                },
                //markLine: {
                //data: [
                //    {type: 'average', name: '平均值'}
                //]
                //}
            },
            {
                name: '睡眠得分',
                type: 'line',
                data: scoreData,
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
