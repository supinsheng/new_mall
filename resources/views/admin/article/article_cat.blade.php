<!DOCTYPE html>
<html>

<head>
    <!-- 页面meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>文章分类管理</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../plugins/adminLTE/css/AdminLTE.css">
    <link rel="stylesheet" href="../plugins/adminLTE/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../css/style.css">
	<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>

</head>

<body class="hold-transition skin-red sidebar-mini" >
  <!-- .box-body -->

                    <div class="box-header with-border">
                        <h3 class="box-title">文章分类管理</h3>
                    </div>

                    <div class="box-body">

                        <!-- 数据表格 -->
                        <div class="table-box">

                            <!--工具栏-->
                            <div class="pull-left">
                                <div class="form-group form-inline">
                                    <div class="btn-group">
										<button type="button" class="btn btn-default" title="新建" data-toggle="modal" data-target="#addModal" ><i class="fa fa-file-o"></i> 新建</button>                                 
                                        <button type="button" class="btn btn-default" title="刷新"  onclick="window.location.reload();"><i class="fa fa-refresh"></i> 刷新</button>
                                    </div>
                                </div>
                            </div>
                          
                            <!--工具栏/-->

			                  <!--数据列表-->
			                  <table id="dataList" class="table table-bordered table-striped table-hover dataTable">
			                      <thead>
			                          <tr>
			                              <th class="" style="padding-right:0px">
			                                  <input id="selall" type="checkbox" class="icheckbox_square-blue">
			                              </th> 
										  <th class="sorting_asc">文章分类ID</th>
									      <th class="sorting">文章分类名称</th>
									      								     						
					                      <th class="text-center">操作</th>
			                          </tr>
			                      </thead>
			                      <tbody>
									@foreach($cats as $cat)
			                          <tr>
			                              <td><input type="checkbox"></td>			                              
				                          <td>{{ $cat->id }}</td>
									      <td>{{ $cat->cat_name }}</td>
		                                  <td class="text-center">                                          
											   <button onclick="return confirm('请注意！！！修改分类对应文章的分类也会改变！！！');" type="button" class="btn bg-olive btn-xs editArticle_cat" data-toggle="modal" data-target="#editModal"  value="{{ $cat->id }}">修改</button> 
											   <button onclick="return confirm('确定要删除吗？');" type="button" style="background-color:#d00" class="btn btn-xs" > <a href="/article/delArticleCat?id={{ $cat->id }}" style="color:#fff">删除</a> </button>                                           
		                                  </td>
			                          </tr>
									@endforeach
			                      </tbody>
			                  </table>
			                  <!--数据列表/-->                        
							  <div style="width:90%;text-align:right">                    
							  	
							  </div>
							 
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
			<h3 id="myModalLabel">分类添加</h3>
		</div>
		<form action="/article/saveArticle_cat" method="post" enctype="multipart/form-data">
		@csrf
		<div class="modal-body">		
			<table class="table table-bordered table-striped"  width="800px">
		      	<tr>
		      		<td>分类名称</td>
		      		<td><input  class="form-control" name="cat_name" placeholder="分类名称" >  </td>
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
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" >
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">品牌编辑</h3>
		</div>
		<form action="" method="post" enctype="multipart/form-data">
		@csrf
		<div class="modal-body">		
			<table class="table table-bordered table-striped"  width="800px">
		      	<tr>
		      		<td>分类名称</td>
		      		<td><input  class="form-control" name="cat_name" >  </td>
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
					@if (session('status'))
						<script>alert( '{{ session('status') }}');</script>
					@endif
</body>

</html>
<script>
	$(".editArticle_cat").click(function(){

		var id = $(this).val();
			
		$.ajax({
			type: 'GET',
			url: '/article/getArticleCatByAjax?id='+id,
			dataType: 'json',
			success: function(data){

				$("#editModal").find("input[name=cat_name]").val(data.cat_name);
				$("#editModal").find("form").attr("action","/article/editArticleCat?id="+id);
			}
		})
	})
</script>