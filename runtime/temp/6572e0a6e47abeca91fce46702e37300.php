<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"D:\phpstudyk\PHPTutorial\WWW\BS\determined\admin\index\index.html";i:1529023548;s:64:"D:\phpstudyk\PHPTutorial\WWW\BS\determined\admin\tpl\header.html";i:1528966530;s:64:"D:\phpstudyk\PHPTutorial\WWW\BS\determined\admin\tpl\footer.html";i:1528849112;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>新领地站点后台系统</title>
  <link rel="stylesheet" href="/static/layui/css/layui.css">
  <link href="/static/layui/css/modules/layer/default/layer.css" rel="stylesheet" type="text/css" media="all"/>
  <link rel="stylesheet" href="/static/admin/style/admin.css">
  <link rel="stylesheet" href="/static/awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/static/admin/style/custom-styles.css">
  <script type="text/javascript" src="/static/jquery/jquery.js"></script>
  <script type="text/javascript" src="/static/jquery/jquery.cookie.js"></script>
  <script type="text/javascript" src="/static/layui/layui.js"></script>
  <script type="text/javascript" src="/static/admin/style/admin.js"></script>
  <script type="text/javascript" src="/static/ecart/echarts.common.min.js"></script>
  <!-- vue -->
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <style type="text/css">
      .layui-table th {
        text-align: center;
      }
      .layui-table td {
        text-align: center;
      }
  </style>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin icon-i">
  <div class="layui-header">
    <div class="layui-logo">XLDBS</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <!-- 控制台 -->
      <li class="layui-nav-item">
        <a href="" title="控制台">
          <i class="fa fa-window-maximize" aria-hidden="true"></i>
        </a>
      </li>
      <li class="layui-nav-item">
        <a href="" title="站点管理">
          <i class="fa fa-edge" aria-hidden="true"></i>
        </a>
      </li>
      <li class="layui-nav-item">
        <a href=""  title="站点统计">
          <i class="fa fa-area-chart" aria-hidden="true"></i>
        </a>
      </li>
      <li class="layui-nav-item">
        <a href="" title="风格">
           <i class="fa fa-bullseye" aria-hidden="true" ></i>
        </a>
      </li>
      <li class="layui-nav-item">
        <a href="" title="刷新">
          <i class="fa fa-refresh" aria-hidden="true"></i>
        </a>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <?php echo \think\Session::get('admin_data.bbsname'); ?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="">基本资料</a></dd>
          <dd><a href="">安全设置</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="">退出</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test" id="web">
        <li class="layui-nav-item layui-nav-itemed">
          <a href="javascript:;">
            <i class="fa fa-edge" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;站点
          </a>
          <dl class="layui-nav-child">
            <dd>
              <a href="<?php echo url('admin/web/newweb'); ?>">
                <i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;添加站点
              </a>
            </dd>
            <dd>
              <a href="<?php echo url('admin/web/list'); ?>">
                <i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;站点列表
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;站点设置
              </a>
            </dd>
          </dl>
        </li>
        <!-- 代理 -->
        <li class="layui-nav-item" id="proxy">
          <a href="javascript:;">
            <i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;代理
          </a>
          <dl class="layui-nav-child">
            <dd>
              <a href="javascript:;">
                <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;新增代理
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;代理管理
              </a>
            </dd>
            <dd>
              <a href="">
                <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;代理设置
              </a>
            </dd>
          </dl>
        </li>
        <!-- 产品中心 -->
        <!--  <li class="layui-nav-item" id="product">
          <a href="javascript:;">
            <i class="fa fa-product-hunt" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;产品
          </a>
          <dl class="layui-nav-child">
            <dd>
              <a href="javascript:;">
                <i class="fa fa-deviantart" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;添加产品
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-list-ol" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;产品列表
              </a>
            </dd>
            <dd>
              <a href="">
                <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;产品设置
              </a>
            </dd>
          </dl>
        </li> -->
        <!-- 站点 统计 -->
        <li class="layui-nav-item" id="proxy">
          <a href="javascript:;">
            <i class="fa fa-area-chart" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;统计
          </a>
          <dl class="layui-nav-child">
            <dd>
              <a href="javascript:;">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;蜘蛛统计
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-line-chart" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;流量统计
              </a>
            </dd>
            <dd>
              <a href="">
                <i class="fa fa-pie-chart" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;站点统计
              </a>
            </dd>
          </dl>
        </li>
        <!-- 内容管理 -->
        <li class="layui-nav-item" id="proxy">
          <a href="javascript:;">
            <i class="fa fa-clipboard" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;内容
          </a>
          <dl class="layui-nav-child">
            <dd>
              <a href="javascript:;">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;文章管理
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;页面管理
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;自定义页面管理
              </a>
            </dd>
          </dl>
        </li>
        <!-- 用户管理 -->
        <li class="layui-nav-item" id="proxy">
          <a href="javascript:;">
           <i class="fa fa-user-o" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;&nbsp;用户
          </a>
          <dl class="layui-nav-child">
            <dd>
              <a href="javascript:;">
                <i class="fa fa-user-secret" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;用户列表
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-align-center" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;权限组管理
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-joomla" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;后台控制器
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;会员配置
              </a>
            </dd>
          </dl>
        </li>
        <!-- 样式 * 模板 -->
        <li class="layui-nav-item" id="proxy">
          <a href="javascript:;">
            <i class="fa fa-bullseye" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;风格
          </a>
          <dl class="layui-nav-child">
            <dd>
              <a href="javascript:;">
                <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;添加模板
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;模板管理
              </a>
            </dd>
          </dl>
        </li>
        <!-- 系统 -->
        <li class="layui-nav-item" id="proxy">
          <a href="javascript:;">
            <i class="fa fa-microchip" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;系统
          </a>
          <dl class="layui-nav-child">
            <dd>
              <a href="javascript:;">
                <i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;清除缓存
              </a>
            </dd>
            <dd>
              <a href="javascript:;">
                <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;系统设置
              </a>
            </dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">

  
<!-- 控制台 -->
<admin-blockquote>
	控制台
</admin-blockquote>
<div class="layui-row">
    <div class="layui-col-md3 layui-col-sm12 layui-col-xs12">
        <div class="panel panel-primary text-center no-boder bg-color-green green">
            <div class="panel-left pull-left green">
                <i class="fa fa-bar-chart fa-5x"></i>
                
            </div>
            <div class="panel-right pull-right">
				<h3 id="totalPV"><?php echo $totalPV; ?></h3>
               <strong>总访问量(PV)</strong>
            </div>
        </div>
    </div>
    <div class="layui-col-md3 layui-col-sm12 layui-col-xs12">
        <div class="panel panel-primary text-center no-boder bg-color-blue blue">
              <div class="panel-left pull-left blue">
                <i class="fa fa-edge fa-5x"></i>
				</div>
                
            <div class="panel-right pull-right">
			<h3 id="totalWEB"><?php echo $totalWEB; ?> </h3>
               <strong>个独立网站</strong>

            </div>
        </div>
    </div>
    <div class="layui-col-md3 layui-col-sm12 layui-col-xs12">
        <div class="panel panel-primary text-center no-boder bg-color-red red">
            <div class="panel-left pull-left red">
                <i class="fa fa-bullseye fa-5x"></i>
               
            </div>
            <div class="panel-right pull-right">
			 <h3 id="totalStyle"><?php echo $totalStyle; ?> </h3>
               <strong>套模板风格</strong>

            </div>
        </div>
    </div>
    <div class="layui-col-md3 layui-col-sm12 layui-col-xs12">
        <div class="panel panel-primary text-center no-boder bg-color-brown brown">
            <div class="panel-left pull-left brown">
                <i class="fa fa-users fa-5x"></i>
                
            </div>
            <div class="panel-right pull-right">
			<h3 id="totalAgent"><?php echo $totalAgent; ?></h3>
             <strong>个信用代理</strong>

            </div>
        </div>
    </div>
</div>

<!--
    #   最近6天统计图
    ->  新增站点
    ->  新增代理
    ->  新增模板
    ->  新增文章
    ->  PV访问量
    ->  蜘蛛访问量    
-->




<div id="last-six-static" style="width: 100%;height: 500px;"></div>
<script type="text/javascript">
    var dom = document.getElementById("last-six-static");
    var myChart = echarts.init(dom);
    var app = {};

    option = null;
    option = {
        title: {
            text: '过去一周统计图'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['新增站点','新增代理','新增模板','新增文章','PV访问量','蜘蛛访问量']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: [<?php echo $lastDate; ?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name:'新增站点',
                type:'line',
                stack: '总量',
                data:[<?php echo $newWEB; ?>]
            },
            {
                name:'新增代理',
                type:'line',
                stack: '总量',
                data:[<?php echo $newAgent; ?>]
            },
            {
                name:'新增模板',
                type:'line',
                stack: '总量',
                data:[<?php echo $newTpl; ?>]
            },
            {
                name:'新增文章',
                type:'line',
                stack: '总量',
                data:[<?php echo $newArt; ?>]
            },
            {
                name:'PV访问量',
                type:'line',
                stack: '总量',
                data:[<?php echo $pvnum; ?>]
            },
            {
                name:'蜘蛛访问量',
                type:'line',
                stack: '总量',
                data:[<?php echo $spidernum; ?>]
            }
        ]
    };
    ;
    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }
</script>

<!--  月度新增详情 包括文章等信息  -->
<!--<div id="last-year-static" style="width: 100%;height: 500px;margin-top: 100px;"></div>-->
<script type="text/javascript">
//    var dom = document.getElementById("last-year-static");
//     var myChart = echarts.init(dom);
//     var app = {};
//     option = null;
//     var data = genData();

//     option = {
//         title : {
//             text: '代理地区分布统计',
//             subtext: '可能存在延时',
//             x:'center'
//         },
//         tooltip : {
//             trigger: 'item',
//             formatter: "{a} <br/>{b} : {c} ({d}%)"
//         },
//         legend: {
//             type: 'scroll',
//             orient: 'vertical',
//             right: 10,
//             top: 20,
//             bottom: 20,
//             data: data.legendData,

//             selected: data.selected
//         },
//         series : [
//             {
//                 name: '姓名',
//                 type: 'pie',
//                 radius : '55%',
//                 center: ['40%', '50%'],
//                 data: data.seriesData,
//                 itemStyle: {
//                     emphasis: {
//                         shadowBlur: 10,
//                         shadowOffsetX: 0,
//                         shadowColor: 'rgba(0, 0, 0, 0.5)'
//                     }
//                 }
//             }
//         ]
//     };

// function genData(count) {
//     var nameList = [
//         '赵', '钱', '孙', '李', '周', '吴', '郑', '王', '冯', '陈', '褚', '卫', '蒋', '沈', '韩', '杨', '朱', '秦', '尤', '许', '何', '吕', '施', '张', '孔', '曹', '严', '华', '金', '魏', '陶', '姜', '戚', '谢', '邹', '喻', '柏', '水', '窦', '章', '云', '苏', '潘', '葛', '奚', '范', '彭', '郎', '鲁', '韦', '昌', '马', '苗', '凤', '花', '方', '俞', '任', '袁', '柳', '酆', '鲍', '史', '唐', '费', '廉', '岑', '薛', '雷', '贺', '倪', '汤', '滕', '殷', '罗', '毕', '郝', '邬', '安', '常', '乐', '于', '时', '傅', '皮', '卞', '齐', '康', '伍', '余', '元', '卜', '顾', '孟', '平', '黄', '和', '穆', '萧', '尹', '姚', '邵', '湛', '汪', '祁', '毛', '禹', '狄', '米', '贝', '明', '臧', '计', '伏', '成', '戴', '谈', '宋', '茅', '庞', '熊', '纪', '舒', '屈', '项', '祝', '董', '梁', '杜', '阮', '蓝', '闵', '席', '季', '麻', '强', '贾', '路', '娄', '危'
//     ];
//     var legendData = [];
//     var seriesData = [];
//     var selected = {};
//     for (var i = 0; i < 50; i++) {
//         name = Math.random() > 0.65
//             ? makeWord(4, 1) + '·' + makeWord(3, 0)
//             : makeWord(2, 1);
//         legendData.push(name);
//         seriesData.push({
//             name: name,
//             value: Math.round(Math.random() * 100000)
//         });
//         selected[name] = i < 6;
//     }

//         console.log(seriesData);
//     return {
//         legendData: '{cityName}',
//         seriesData: '{cityseries}',
//         selected: selected
//     };

//     function makeWord(max, min) {
//         var nameLen = Math.ceil(Math.random() * max + min);
//         var name = [];
//         for (var i = 0; i < nameLen; i++) {
//             name.push(nameList[Math.round(Math.random() * nameList.length - 1)]);
//         }
//         return name.join('');
//     }
// }
// ;
// if (option && typeof option === "object") {
//     myChart.setOption(option, true);
// }
</script>






<!-- vue渲染开始 -->
<script type="text/javascript"></script>

    </div>
  </div>
<div class="layui-footer">
    <!-- 底部固定区域 -->
    © XLDCMS
  </div>
</div>
<script>
layui.use('element', function(){
  var element = layui.element;
});
</script>
</body>
</html>
