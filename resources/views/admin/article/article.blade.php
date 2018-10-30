<!DOCTYPE html>
<html>

<head>
    <!-- 页面meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>文章管理</title>
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
                        <h3 class="box-title">文章管理</h3>
                    </div>

                    <div class="box-body">

                        <!-- 数据表格 -->
                        <div class="table-box">

                            <!--工具栏-->
                            <div class="pull-left">
                                <div class="form-group form-inline">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" title="添加文章"  onclick="javascript:window.location.href='/article/addArticle';" ><i class="fa fa-trash-o"></i>添加文章</button>                                
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
										  <th class="sorting_asc">文章ID</th>
									      <th class="sorting">文章名称</th>
									      <th class="sorting">跳转地址</th>
									      <th class="sorting">分类</th>
					                      <th class="text-center">操作</th>
			                          </tr>
			                      </thead>
			                      <tbody>
									@foreach($articles as $article)
			                          <tr>
			                              <td><input type="checkbox"></td>			                              
				                          <td>{{ $article->id }}</td>
									      <td>{{ $article->title }}</td>
									      <td>{{ $article->link }}</td>
									      <td>{{ $article->cat_name }}</td>
		                                  <td class="text-center">                                          
											   <button type="button" class="btn bg-olive btn-xs" ><a href="/article/edit?id={{ $article->id }}" style="color:#fff">修改</a></button> 
											   <button onclick="return confirm('确定要删除吗？');" type="button" style="background-color:#d00" class="btn btn-xs" > <a href="/article/delArticle?id={{ $article->id }}" style="color:#fff">删除</a> </button>                                           
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
					@if (session('status'))
						<script>alert( '{{ session('status') }}');</script>
					@endif
</body>

</html>