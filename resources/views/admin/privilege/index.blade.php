<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>权限管理</title>
    <meta content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../plugins/adminLTE/css/AdminLTE.css">
    <link rel="stylesheet" href="../plugins/adminLTE/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../css/style.css">
	<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
    
</head>
<body class="hold-transition skin-red sidebar-mini">
  <!-- .box-body -->
                    <div class="box-header with-border">
                        <h3 class="box-title">权限管理</h3>
                    </div>

                    <div class="box-body">

                        <!-- 数据表格 -->
                        <div class="table-box">

                            <!--工具栏-->
                            <div class="pull-left">
                                <div class="form-group form-inline">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" title="新建" data-toggle="modal" data-target="#addModal" ><i class="fa fa-file-o"></i> 新建</button>         
                                        <button type="button" class="btn btn-default" title="刷新" onclick="window.location.reload();"><i class="fa fa-refresh"></i> 刷新</button>
                                    </div>
                                </div>
                            </div>
                            <div class="box-tools pull-right">
                                <div class="has-feedback">
							                                         
                                </div>
                            </div>
                            <!--工具栏/-->

			                  <!--数据列表-->
			                  <table id="dataList" class="table table-bordered table-striped table-hover dataTable">
			                      <thead>
			                          <tr>
										  <th class="sorting_asc">权限ID</th>
									      <th class="sorting">权限名称</th>									      
									      <th class="sorting">权限地址</th>									     				
					                      <th class="text-center">操作</th>
			                          </tr>
			                      </thead>
			                      <tbody>
									@foreach($pris as $pri)
			                          <tr>			                              
				                          <td>{{ $pri->id }}</td>
									      <td>{{ $pri->pri_name }}</td>									     
		                                  <td>{{ $pri->url_path }}</td>		                                 
		                                  <td class="text-center">                                           
											   <!-- <button type="button" class="btn bg-olive btn-xs editPri" data-toggle="modal" data-target="#editModal"  value="{{ $pri->id }}">修改</button> -->
											   <button onclick="return confirm('请注意！！！<?php echo '\r'?>删除该权限也会删除拥有该权限的所有 角色 和 管理员！！！<?php echo '\r'?>确定要删除吗？');" type="button" style="background-color:#d00" class="btn btn-xs" > <a href="/privilege/delPri?id={{ $pri->id }}" style="color:#fff">删除</a> </button>                                           
		                                  </td>
			                          </tr>
									@endforeach
			                      </tbody>
			                  </table>
							  <!--数据列表/-->   
							
							 
                        </div>
                        <!-- 数据表格 /-->
                        
                        
                        
                        
                     </div>
                    <!-- /.box-body -->
         
<!-- 添加窗口 -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" >
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">权限添加</h3>
		</div>
		<form action="/privilege/savePri" method="post">
		@csrf
		<div class="modal-body">		
			<table class="table table-bordered table-striped"  width="800px">
		      	<tr>
		      		<td>权限名称</td>
		      		<td><input  class="form-control" name="pri_name" placeholder="权限名称" >  </td>
		      	</tr>		      	
		      	<tr>
		      		<td>权限地址</td>
		      		<td><input  class="form-control" name="url_path" placeholder="权限地址（格式为：/xxxx/xxxx，多个地址用英文逗号','隔开）" >  </td>
		      	</tr>		      	
			 </table>				
		</div>
		<div class="modal-footer">		
			<input type="submit" value="保存" class="btn btn-success">
			<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</button>
		</div>
		</form>
	  </div>
	</div>
</div>

<!-- 编辑窗口 -->
<!-- <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" >
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">权限编辑</h3>
		</div>
		<form action="" method="post" enctype="multipart/form-data">
		@csrf
		<div class="modal-body">		
			<table class="table table-bordered table-striped"  width="800px">
		      	<tr>
		      		<td>权限名称</td>
		      		<td><input  class="form-control" name="pri_name" >  </td>
		      	</tr>		      	
		      	<tr>
		      		<td>权限地址</td>
		      		<td><input  class="form-control" name="url_path" >  </td>
		      	</tr>		      	
			 </table>				
		</div>
		<div class="modal-footer">		
			<input type="submit" value="保存" class="btn btn-success">
			<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</button>
		</div>
		</form>
	  </div>
	</div>
</div> -->

@if (session('status'))
    <script>alert( '{{ session('status') }}');</script>
@endif
   
</body>
</html>
<script src="/js/img_preview.js"></script>
<script>
	// $(".editPri").click(function(){

	// 	var id = $(this).val();
			
	// 	$.ajax({
	// 		type: 'GET',
	// 		url: '/privilege/getPriByAjax?id='+id,
	// 		dataType: 'json',
	// 		success: function(data){

	// 			$("#editModal").find("input[name=pri_name]").val(data.pri_name);
	// 			$("#editModal").find("input[name=url_path]").val(data.url_path);
	// 			$("#editModal").find("form").attr("action","/privilege/editPri?id="+id);
	// 		}
	// 	})
	// })
</script>