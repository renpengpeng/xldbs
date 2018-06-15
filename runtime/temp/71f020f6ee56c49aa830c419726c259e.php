<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:59:"D:\phpstudyk\PHPTutorial\WWW\BS\sysview\admin\web\list.html";i:1528963698;s:64:"D:\phpstudyk\PHPTutorial\WWW\BS\determined\admin\tpl\header.html";i:1528966530;s:64:"D:\phpstudyk\PHPTutorial\WWW\BS\determined\admin\tpl\footer.html";i:1528849112;}*/ ?>
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

  
<admin-blockquote>站点列表</admin-blockquote>

<table class="layui-table">
	<thead>
      <tr>
        <th>ID</th>
        <th>标题</th>
        <th>关键词</th>
        <th>ICP备案号</th>
        <th>管理账号</th>
        <th>管理密码</th>
        <th>运行状态</th>
        <th>开始运行</th>
        <th>结束运行</th>
        <th>操作</th>
      </tr> 
    </thead>
    <?php if(is_array($listData) || $listData instanceof \think\Collection || $listData instanceof \think\Paginator): $i = 0; $__LIST__ = $listData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
    	<tr>
    		<td><?php echo $list['id']; ?></td>
    		<td><?php echo $list['title']; ?></td>
    		<td><?php echo $list['keywords']; ?></td>
    		<td><?php echo $list['icp']; ?></td>
    		<td><?php echo $list['adminusername']; ?></td>
    		<td><?php echo $list['adminpassword']; ?></td>
    		<td>
    			<?php if($list['status'] == 1): ?>
    			    <span class="layui-badge-dot layui-bg-green" title="运行中"></span>
    			<?php else: ?>
    				<span class="layui-badge-dot" title="停止"></span>
    			<?php endif; ?>
    		</td>
    		<td><?php echo $list['begindate']; ?></td>
    		<td><?php echo $list['enddate']; ?></td>
    		<td>
    			<div class="layui-btn-group">
				  
				  <button class="layui-btn layui-btn-sm" title="编辑">
				    <i class="layui-icon">&#xe642;</i>
				  </button>
				  <button class="layui-btn layui-btn-sm" title="删除">
				    <i class="layui-icon">&#xe640;</i>
				  </button>
				  <button class="layui-btn layui-btn-sm" title="切换后台">
				    <i class="layui-icon">&#xe602;</i>
				  </button>
				</div>
    		</td>
    	</tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</table>
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