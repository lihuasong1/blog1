<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"E:\phpstudy\WWW\blog\public/../application/admin\view\manager\index.html";i:1532008490;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>网站后台管理模版</title>
		<link rel="stylesheet" type="text/css" href="/static/admin/layui/css/layui.css" />
		<link rel="stylesheet" type="text/css" href="/static/admin/css/admin.css" />
	</head>
	<body>
		<div class="wrap-container">
				<div class="column-content-detail">
					<form class="layui-form" action="">
						<div class="layui-form-item">
							<div class="layui-inline tool-btn">
								<button class="layui-btn layui-btn-small layui-btn-normal addBtn" data-id="1" data-url="<?php echo url('admin/manager/create'); ?>"><i class="layui-icon">&#xe654;</i></i></button>
								<button class="layui-btn layui-btn-small layui-btn-warm listOrderBtn hidden-xs" id="refresh" onclick="return false"><i class="iconfont">&#xe656;</i></button>
							</div>
							<div class="layui-inline">
								<input type="text" name="name" placeholder="请输入名称" autocomplete="off" class="layui-input">
							</div>
							<div class="layui-inline">
								<select name="states" lay-filter="status">
									<option value="">请选择一个状态</option>
									<option value="010">显示</option>
									<option value="021">隐藏</option>
								</select>
							</div>
							<button class="layui-btn layui-btn-normal" onclick="return false"  id="search" lay-submit="search">搜索</button>
						</div>
					</form>
					<div class="layui-form" id="category-table-list">
						<table class="layui-table" lay-even lay-skin="nob">
							<colgroup>
								<col width="50">
								<col class="hidden-xs" width="50">
								<col width="200">
								<col class="hidden-xs">
								<col class="hidden-xs">
								<col class="hidden-xs">
								<col class="hidden-xs" width="100">
								<col width="150">
							</colgroup>
							<thead>
								<tr>
									<th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
									<th class="hidden-xs">ID</th>
									<th>用户名</th>
									<th class="hidden-xs">登录ip</th>
									<th class="hidden-xs">邮箱</th>
									<th class="hidden-xs">昵称</th>
									<th class="hidden-xs">上次登录时间</th>
									<th class="hidden-xs">用户组</th>
									<th class="hidden-xs">状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody id="tbody">
								<?php foreach($list as $v): ?>
								<tr>
									<td><input type="checkbox" name="" lay-skin="primary"  data-id="1"></td>
									<td class="hidden-xs"><?php echo $v['id']; ?></td>
									<td><?php echo $v['username']; ?></td>
									<td class="hidden-xs"><?php echo $v['ip']; ?></td>
									<td class="hidden-xs"><?php echo $v['email']; ?></td>
									<td class="hidden-xs"><?php echo $v['nickname']; ?></td>
									<td class="hidden-xs"><?php echo date('Y-m-d H:i:s',$v['last_login_time']); ?></td>
									<td class="hidden-xs"><?php echo $v['role_id']; ?></td>
									<td><button class="layui-btn layui-btn-mini layui-btn-warm">拉黑</button></td>
									<td>
										<div class="layui-inline">
											<a href="<?php echo url('admin/manager/edit'); ?>?id=<?php echo $v['id']; ?>"><button class="layui-btn layui-btn-small layui-btn-normal  edit-btn" data-id="1" data-url="<?php echo url('admin/manager/edit'); ?>?id=<?php echo $v['id']; ?>"><i class="layui-icon">&#xe642;</i></button></a>
											<button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="1"><i class="layui-icon">&#xe640;</i></button>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<!--tp分页-->
						<div class="page-wrap">
							<ul class="pagination">
								<li class="disabled"><span>«</span></li>
								<li class="active"><span>1</span></li>
								<li>
									<a href="/admin/category/index.html?page=2">2</a>
								</li>
								<li>
									<a href="/admin/category/index.html?page=2">»</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
		</div>
		<script src="/static/admin/layui/layui.js" type="text/javascript" charset="utf-8"></script>
		<script src="/static/admin/js/jquery.min.js"></script>
		<script type="text/javascript">
			var SCOPE = {
				static: '/static',
				index: '/admin/category/index.html',
				edit: 'menu-add.html',
				updateEdit: '/admin/category/updateedit.html',
				status: '/admin/category/updatestatus.html',
				del: '/admin/category/del.html',
				listOrderAll: '/admin/category/listorderall.html'
			}
		</script>
		<script>
			layui.config({
				base: '/static/admin/js/module/'
			}).extend({
				dialog: 'dialog',
				load: 'load',
				common: 'common'
			});
			layui.use(['form', 'jquery', 'layer', 'dialog', 'common', 'element'], function() {
				var form = layui.form(),
					layer = layui.layer,
					$ = layui.jquery,
					common = layui.common,
					element = layui.element(),
					dialog = layui.dialog;
				//获取当前iframe的name值
				var iframeObj = $(window.frameElement).attr('name');
				//全选
				form.on('checkbox(allChoose)', function(data) {
					var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
					child.each(function(index, item) {
						item.checked = data.elem.checked;
					});
					form.render('checkbox');
				});
				form.render();
				//顶部添加
				$('.addBtn').click(function() {
					//将iframeObj传递给父级窗口,执行操作完成刷新
					parent.page("菜单添加", SCOPE.add, iframeObj, w = "700px", h = "620px");
					return false;

				}).mouseenter(function() {
					dialog.tips('添加', '.addBtn');
				})
				//列表添加
				$('.add-btn').click(function() {
					//将iframeObj传递给父级窗口
					parent.page("菜单添加", SCOPE.add, iframeObj, w = "700px", h = "620px");
					return false;
				})
				//删除
				$('.del-btn').on('click', function() {
					var id = $(this).attr('data-id');
					common.del(SCOPE.del, id);
				})
				//排序
				$('.listOrderBtn').click(function() {
					common.listOrderAll(SCOPE.listOrderAll, '您确定要进行排序吗？');
					return false;
				}).mouseenter(function() {
					dialog.tips('排序', '.listOrderBtn');
				})
				//编辑栏目
				$('#category-table-list').on('click', '.edit-btn', function() {
					var That = $(this);
					var id = That.attr('data-id');
					//将iframeObj传递给父级窗口
					parent.page("菜单编辑", SCOPE.edit + "?id=" + id, iframeObj, w = "700px", h = "620px");
				});
			});
			//实现局部刷新
			$('#refresh').click(function() {
				// alert(123);
				$.ajax({
					'url' : "<?php echo url('admin/manager/refresh'); ?>",
					'type' : 'post',
					'dataType' : 'json',
					'success' : function(res) {
						if (res.code != 700) {
						    layer.msg('刷新失败');
						    return;
						}else {
							var str = '';
							var data = res.data;
						    // layer.msg('123');
						    // console.log(res.data);
						    //遍历返回数据写到	html页面
						    $.each(data, function(i, v) {
						    	// alert(123);
			    				str += "<tr>" +
								"<td><input type=\"checkbox\" name=\"\" lay-skin=\"primary\"  data-id=\"1\"></td>" +
								"<td class=\"hidden-xs\">"+v.id +"</td>" +
								"<td class=\"hidden-xs\">"+v.username+"</td>" +
								"<td class=\"hidden-xs\">127.0.0.1</td>" +
								"<td class=\"hidden-xs\">1989-10-14</td>" +
								"<td class=\"hidden-xs\">[编辑]</td>\n" +
								"<td><button class=\"layui-btn layui-btn-mini layui-btn-normal block\">正常</button></td>" +
								"<td>" +
								"<div class=\"layui-inline\">" +
								"<button class=\"layui-btn layui-btn-small layui-btn-normal  edit-btn\" data-id=\"1\"><i class=\"layui-icon\">&#xe642;</i></button>" +
								"<button class=\"layui-btn layui-btn-small layui-btn-danger del-btn\" data-id=\"1\"><i class=\"layui-icon\">&#xe640;</i></button>" +
								"</div>" +
								"</td>" +
								"</tr>";
			    		});
			    	//将拼接好的字符串放到html页面
			    	$('#tbody').html(str);
						}
					}
				});
			});
			$(function() {
			    //拉黑
			    $('.block').click(function() {
			        var val = $(this).html();
			        if(val == '正常') {
			            $(this).html('拉黑');
			            $(this).removeClass('layui-btn-normal');
			            $(this).addClass('layui-btn-warm');
			        }else {
			            $(this).html('正常');
			            $(this).removeClass('layui-btn-warm');
			            $(this).addClass('layui-btn-normal');
			        }
			    });
				//搜索
				$("#search").click(function () {
					// alert(123);
					var name = $('form').find("[name=name]").val();
					//组装json返回数据
					var data = {
						"name":name
					};
					$.ajax({
						"url" : "<?php echo url('admin/manager/getFindManager'); ?>",
						"type" : "post",
						"data" : data,
						"dataType" : "json",
						success : function (res) {
							//如果不等于700返回查询失败
							if(!res.code == 700 ) {
								layui.alert('查询失败');
								return;
							}else {
						// console.log(res.data);
						//获取结果
						var data = res.data;
						var str = "";
						$.each(data, function(i, v) {
						    console.log(v);
							str += "<tr>" +
							"<td><input type=\"checkbox\" name=\"\" lay-skin=\"primary\"  	data-id=\"1\"></td>" +
							"<td class=\"hidden-xs\">"+v.id +"</td>" +
							"<td class=\"hidden-xs\">"+v.username+"</td>" +
							"<td class=\"hidden-xs\">"+ v.ip+"</td>" +
							"<td class=\"hidden-xs\">"+ v.email+"</td>" +
							"<td class=\"hidden-xs\">"+ v.nickname+"</td>" +
							"<td class=\"hidden-xs\">"+ v.last_login_time+"</td>" +
							"<td class=\"hidden-xs\">["+ v.role_id+"]</td>\n" +
							"<td><button class=\"layui-btn layui-btn-mini layui-btn-normal block\">正常</button></td>" +
							"<td>" +
							"<div class=\"layui-inline\">" +
							"<button class=\"layui-btn layui-btn-small layui-btn-normal  edit-btn\" data-id=\"1\"><i class=\"layui-icon\">&#xe642;</i></button>" +
							"<button class=\"layui-btn layui-btn-small layui-btn-danger del-btn\" data-id=\"1\"><i class=\"layui-icon\">&#xe640;</i></button>" +
							"</div>" +
							"</td>" +
							"</tr>";
						});
						$('#tbody').html(str);
					}
				}
			});
		});
	});
</script>
</body>
</html>