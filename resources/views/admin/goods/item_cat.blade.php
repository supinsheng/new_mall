<!DOCTYPE html>
<html>

<head>
    <!-- 页面meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>商品分类管理</title>
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
                        <h3 class="box-title">商品分类管理     
                       	</h3>
                    </div>

                    <div class="box-body">
                  			 <ol class="breadcrumb">	                        	
                        		<li>
		                        	<a href="#" >顶级分类列表</a> 
		                        </li>
		                        <li>
		                       		<a href="#" >珠宝</a>
		                        </li>
		                        <li>
		                        	<a href="#" >银饰</a>
		                        </li>
	                        </ol>

                        <!-- 数据表格 -->
                        <div class="table-box">
							
                            <!--工具栏-->
                            <div class="pull-left">
                                <div class="form-group form-inline">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" title="新建" data-toggle="modal" data-target="#addModal" ><i class="fa fa-file-o"></i> 新建</button>
                                        <button type="button" class="btn btn-default" title="刷新"  onclick="window.location.reload();"><i class="fa fa-check"></i> 刷新</button>
                                       
                                    </div>
                                </div>
                            </div>                          
                       		
                        
			                <!--数据列表-->
			                  <table id="dataList" class="table table-bordered table-striped table-hover dataTable">
			                      <thead>
			                          <tr>
			                              <th class="" style="padding-right:0px">
			                                  <input type="checkbox" class="icheckbox_square-blue">
			                              </th> 
										  <th class="sorting_asc">分类ID</th>
									      <th class="sorting">分类名称</th>									   
									      <th class="sorting">父级id</th>
									      <th class="sorting">所有父级id</th>
									     						
					                      <th class="text-center">操作</th>
			                          </tr>
			                      </thead>
			                      <tbody>
			                         @foreach($cats as $cat)
									  <tr >
			                              <td><input  type="checkbox" ></td>			                              
				                          <td>{{ $cat->id }}</td>
									      <td>{{ str_repeat('-',6*(count(explode('-',$cat->path))-2)).$cat->cat_name }}</td>									    
									      <td>{{ $cat->parent_id }}</td>									      
									      <td>{{ $cat->path }}</td>									      
		                                  <td class="text-center">                                     
		                                 	  <button type="button" class="btn bg-olive btn-xs editCat" data-toggle="modal" data-target="#editModal" value="{{ $cat->id }}">修改</button>    
											  <button onclick="return confirm('确定要删除吗？');" type="button" style="background-color:#d00" class="btn btn-xs" > <a href="/goods/delCat?id={{ $cat->id }}" style="color:#fff">删除</a> </button>                                       
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
			<h3 id="myModalLabel">商品分类添加</h3>
		</div>
		<form action="/goods/saveCat" method="post">
		@csrf
		<div class="modal-body">							
			
			<table class="table table-bordered table-striped"  width="800px">
				<tr>
		      		<td>上级商品分类</td>
		      		<td>
		      		  	<select name="parent_id">
							<option value="0">默认为最高级</option>
							@foreach($cats as $cat)
								@if(count(explode('-',$cat->path)) < 4)
								<option value="{{ $cat->id }}|{{ $cat->path }}">{{ str_repeat('-',8*(count(explode('-',$cat->path))-2)).$cat->cat_name }}</option>		
								@endif
								
							@endforeach
						</select>
		      		</td>
		      	</tr>
		      	<tr>
		      		<td>商品分类名称</td>
		      		<td><input  class="form-control" name="cat_name" placeholder="商品分类名称">  </td>
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
			<h3 id="myModalLabel">商品分类编辑</h3>
		</div>
		<form action="" method="post">
		@csrf
		<div class="modal-body">							
			
			<table class="table table-bordered table-striped"  width="800px">
				<tr>
		      		<td>上级商品分类</td>
		      		<td>
		      		  	<select name="parent_id">
							<option value="0">默认为最高级</option>
							@foreach($cats as $cat)
								@if(count(explode('-',$cat->path)) < 4)
								<option selected value="{{ $cat->id }}|{{ $cat->path }}">{{ str_repeat('-',8*(count(explode('-',$cat->path))-2)).$cat->cat_name }}</option>		
								@endif
								
							@endforeach
						</select>
		      		</td>
		      	</tr>
		      	<tr>
		      		<td>商品分类名称</td>
		      		<td><input  class="form-control" name="cat_name" value="" placeholder="商品分类名称">  </td>
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
	$(".editCat").click(function(){

		var id = $(this).val();

		$.ajax({
			type: 'GET',
			url: '/goods/getCatByAjax?id='+id,
			dataType: 'json',
			success: function(data){

				for(var i=0;i<$("#editModal").find("option").length;i++){
					// console.log($("#editModal").find("option")[i].value);
					var value = $("#editModal").find("option")[i].value;
					value = value.split("|");
					// console.log(data.parent_id+'|'+data.path);
					if(data.parent_id == value[0]){
						
						$("#editModal").find("option")[i].selected='selected';
					}
				}
			
				$("#editModal").find("input[name=cat_name]").val(data.cat_name);
				$("#editModal").find("form").attr("action","/goods/editCat?id="+id);
			}
		})
	})
</script>