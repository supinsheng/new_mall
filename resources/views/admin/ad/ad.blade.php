<!DOCTYPE html>
<html>

<head>
    <!-- 页面meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>广告管理</title>
    <!-- Tell the browser to be responsive to screen width -->
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
                        <h3 class="box-title">广告管理</h3>
                    </div>

                    <div class="box-body">

                        <!-- 数据表格 -->
                        <div class="table-box">

                            <!--工具栏-->
                            <div class="pull-left">
                                <div class="form-group form-inline">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" title="新建" data-toggle="modal" data-target="#addModal" ><i class="fa fa-file-o"></i> 新建</button>
                                        <!-- <button type="button" class="btn btn-default" title="删除" ><i class="fa fa-trash-o"></i> 删除</button> -->
                                        <!-- <button type="button" class="btn btn-default" title="开启" onclick='confirm("你确认要开启吗？")'><i class="fa fa-check"></i> 开启</button> -->
                                        <!-- <button type="button" class="btn btn-default" title="屏蔽" onclick='confirm("你确认要屏蔽吗？")'><i class="fa fa-ban"></i> 屏蔽</button> -->
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
			                              <th class="" style="padding-right:0px">
			                                  <input id="selall" type="checkbox" class="icheckbox_square-blue">
			                              </th> 
										  <th class="sorting_asc">广告ID</th>
									      <th class="sorting">标题</th>
									      <th class="sorting">URL</th>		
									      <th class="sorting">图片</th>	
									      <th class="sorting">是否显示</th>											     						      							
					                      <th class="text-center">操作</th>
			                          </tr>
			                      </thead>
			                      <tbody>
								  @foreach($ads as $ad)
			                          <tr>
			                              <td><input  type="checkbox"></td>			                              
				                          <td>{{ $ad->id }}</td>
									      <td>{{ $ad->title }}</td>
									      <td>{{ $ad->link }}</td>
									      <td>
									      	<img src="{{ $ad->image }}" width="100px" height="50px">
									      </td>
									      @if($ad->is_show == 'y')
									      <td>显示</td>	
										  @else
										  <td>不显示</td>
										  @endif								     								     
		                                  <td class="text-center">                                           
		                                 	  <button type="button" class="btn bg-olive btn-xs editAd" data-toggle="modal" data-target="#editModal" value="{{ $ad->id }}">修改</button>         
											   <button onclick="return confirm('确定要删除吗？');" type="button" style="background-color:#d00" class="btn btn-xs" > <a href="/ad/delAd?id={{ $ad->id }}" style="color:#fff">删除</a> </button>                                  
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
			<h3 id="myModalLabel">广告添加</h3>
		</div>
		<form action="/ad/saveAd" method="post" enctype="multipart/form-data">
		@csrf
		<div class="modal-body">							
			
			<table class="table table-bordered table-striped"  width="800px">
				
		      	<tr>
		      		<td>标题</td>
		      		<td><input name="title" class="form-control" placeholder="标题" >  </td>
		      	</tr>
			    <tr>
		      		<td>URL</td>
		      		<td><input name="link" class="form-control" placeholder="URL" >  </td>
		      	</tr>	
		      				      	
		      	<tr>
		      		<td>广告图片</td>
		      		<td>
						<table>
							<tr>
								<td><input type="file" name="image" id="file" /></td>
							</tr>						
						</table>
		      		</td>
		      	</tr>	      
		      	<tr>
		      		<td>是否显示</td>
		      		<td>
		      		   <input type="radio" name="is_show" value="y" class="icheckbox_square-blue" checked>显示
					   <input type="radio" name="is_show" value='n' class="icheckbox_square-blue" >不显示
		      		</td>
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
			<h3 id="myModalLabel">广告编辑</h3>
		</div>
		<form action="" method="post" enctype="multipart/form-data">
		@csrf
		<div class="modal-body">							
			
			<table class="table table-bordered table-striped"  width="800px">
				
		      	<tr>
		      		<td>标题</td>
		      		<td><input name="title" class="form-control" placeholder="标题" >  </td>
		      	</tr>
			    <tr>
		      		<td>URL</td>
		      		<td><input name="link" class="form-control" placeholder="URL" >  </td>
		      	</tr>	
		      				      	
		      	<tr>
		      		<td>广告图片</td>
		      		<td>
						<table>
							<tr>
								<td><input type="file" name="image" id="file" /></td>
							</tr>						
						</table>
		      		</td>
		      	</tr>	      
		      	<tr>
		      		<td>是否显示</td>
		      		<td>
		      		   <input type="radio" name="is_show" value="y" class="icheckbox_square-blue" >显示
					   <input type="radio" name="is_show" value='n' class="icheckbox_square-blue" >不显示
		      		</td>
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
	$(".editAd").click(function(){

		var id = $(this).val();	
			
		$.ajax({
			type: 'GET',
			url: '/ad/getAdByAjax?id='+id,
			dataType: 'json',
			success: function(data){

				$("#editModal").find("input[name=title]").val(data.title);
				$("#editModal").find("input[name=link]").val(data.link);
				for(var i=0;i<$("#editModal").find("input[name=is_show]").length;i++){
					if($("#editModal").find("input[name=is_show]")[i].value == data.is_show){
						$("#editModal").find("input[name=is_show]")[i].checked = 'checked';
					}
				}
				if($("#editModal").find("input[name=is_show]").val() == data.is_show){
					$("#editModal").find("input[name=is_show]").cheak = 'checked';
				}
				$("#editModal").find("form").attr("action","/ad/editAd?id="+id);
			}
		})
	})
</script>