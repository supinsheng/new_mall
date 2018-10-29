<!DOCTYPE html>
<html>

<head>
    <!-- 页面meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>商品管理</title>
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
                        <h3 class="box-title">商品管理</h3>
                    </div>

                    <div class="box-body">

                        <!-- 数据表格 -->
                        <div class="table-box">

                            <!--工具栏-->
                            <div class="pull-left">
                                <div class="form-group form-inline">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" title="添加商品"  onclick="javascript:window.location.href='/goods/add';" ><i class="fa fa-trash-o"></i>添加商品</button>                                
                                        <button type="button" class="btn btn-default" title="刷新"  onclick="window.location.reload();"><i class="fa fa-refresh"></i> 刷新</button>
                                    </div>
                                </div>
                            </div>
                            <div class="box-tools pull-right">
                                <div class="has-feedback">
                                    商品名称：<input >
									<button class="btn btn-default" >查询</button>                                    
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
										  <th class="sorting_asc">商品ID</th>
									      <th class="sorting">商品名称</th>
									      <th class="sorting">一级分类</th>
									      <th class="sorting">二级分类</th>
										  <th class="sorting">三级分类</th>
									      <th class="sorting">品牌</th>
									      <th class="sorting">是否上架</th>									     						
					                      <th class="text-center">操作</th>
			                          </tr>
			                      </thead>
			                      <tbody>
									  @foreach($goods as $good)
			                          <tr>
			                              <td><input type="checkbox"></td>			                              
				                          <td>{{ $good->id }}</td>
									      <td>{{ $good->goods_name }}</td>
									      <td>{{ explode(',',$good->cat_name)[0] }}</td>
									      <td>{{ explode(',',$good->cat_name)[1] }}</td>
									      <td>{{ explode(',',$good->cat_name)[2] }}</td>
									      <td>{{ $good->brand_name }}</td>
		                                  <td>		                                  
		                                  	<span>
											  @if($good->is_on_sale == 'y')
											  上架
											  @else
											  下架
											  @endif
		                                  	</span>
		                                  	
		                                  </td>		                                  
		                                  <td class="text-center">                                          
											   <button type="button" class="btn bg-olive btn-xs" ><a href="/goods/edit?id={{ $good->id }}" style="color:#fff">修改</a></button> 
											   <button onclick="return confirm('确定要删除吗？');" type="button" style="background-color:#d00" class="btn btn-xs" > <a href="/goods/delGood?id={{ $good->id }}" style="color:#fff">删除</a> </button>                                           
		                                  </td>
			                          </tr>
									  @endforeach
			                      </tbody>
			                  </table>
			                  <!--数据列表/-->                        
							  <div style="width:90%;text-align:right">                    
							  	{{ $goods->links() }}
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