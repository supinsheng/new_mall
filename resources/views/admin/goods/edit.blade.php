<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <title>管理中心 - 添加新记录 </title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/css/general.css" rel="stylesheet" type="text/css" />
	<link href="/css/main.css" rel="stylesheet" type="text/css" />
	<style>
        .img-container {
            width: 400px;
            height: 400px;
            float:left;
        }
        .img-preview {
            float: left;
            overflow: hidden;
            margin-left: 20px;
        }
        .preview-lg {
            width: 220px;
            height: 220px;
        }
        .preview-md {
            width: 56px;
            height: 56px;
        }

        .clearfix {
            clear:both;
        }

        #logo {
            float: left;
        }
        
    </style>
</head>

<body>
    <h1>
        <span class="action-span"><a href="/admin/goods">数据列表</a></span>
        <span class="action-span1"><a href="/admin/goods">商品管理</a></span>
        <span id="search_id" class="action-span1"> - 添加新记录 </span>
        <div style="clear:both"></div>
    </h1>
    <div class="main-div">
		<form action="/goods/insert" method="post" name="theForm" enctype="multipart/form-data">
			@csrf
            <table width="100%" id="general-table">
                <tr>
                    <td class="label">商品名称</td>
                    <td>
                        <input type='text' size="80" name='goods_name'>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">LOGO</td>
                    <td>
                        <input type='file' class="clearfix" id="logo" size="80" name='logo'>
						<font color="red">*</font>
						<!-- 显示原图 -->
						<div class="img-container clearfix">
							<img id="image" src="" alt="Picture">
						</div>
						<!-- 预览图片 -->
						<div class="docs-preview">
							<div class="img-preview preview-lg"></div>
							<div class="img-preview preview-md"></div>
						</div>
						<input type="hidden" name="x">
						<input type="hidden" name="y">
						<input type="hidden" name="w">
						<input type="hidden" name="h">
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="y" checked> 是
                        <input type="radio" name="is_on_sale" value="n"> 否
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品描述</td>
                    <td id="content">
						
					</td>
					<textarea id="text1" style="display:none" name="describe"></textarea>
                </tr>
                <tr>
                    <td class="label">一级分类ID:</td>
                    <td>
                        <select name="cat1_id">
                            @foreach($topCats as $topCat)
                            <option value="{{ $topCat->id }}">
                                {{ $topCat->cat_name }}
                            </option>
                            @endforeach
                        </select>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">二级分类ID:</td>
                    <td>
                        <select name="cat2_id"></select>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">三级分类ID:</td>
                    <td>
                        <select name="cat3_id"></select>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">品牌ID</td>
                    <td>
                        <select name="brand_id">
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">
                                {{ $brand->brand_name }}
                            </option>
                            @endforeach
                        </select>
                        <font color="red">*</font>
                    </td>
                </tr>
            </table>

            <h3>商品属性 <input id="btn-attr" type="button" value="添加一个属性"></h3>
            <div id="attr-container">
                <table width="100%">
                    <tr>
                        <td class="label">属性名称:</td>
                        <td>
                            <input type='text' size="80" name='attr_name[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">属性值:</td>
                        <td>
                            <input type='text' size="80" name='attr_value[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    
                </table>
            </div>

            <h3>商品图片 <input id="btn-image" type="button" value="添加一个图片"></h3>
            <div id="image-container">
                <table width="100%">
                    <tr>
                        <td class="label"></td>
                        <td>
                            <input class="preview" type='file' name='image[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                </table>
            </div>

            <h3>SKU <input id="btn-sku" type="button" value="添加一个sku"></h3>
            <div id="sku-container">
                <table width="100%">
                    <tr>
                        <td class="label">SKU名称:</td>
                        <td>
                            <input type='text' size="80" name='sku_name[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">库存量:</td>
                        <td>
                            <input type='text' size="80" name='stock[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">价格:</td>
                        <td>
                            ￥ <input type='text' size="10" name='price[]'> 元
                            <font color="red">*</font>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="button-div">
                <input type="submit" value=" 确定 " />
                <input type="reset" value=" 重置 " />
            </div>
        </form>
    </div>

    @if (session('status'))
		<script>alert( '{{ session('status') }}');</script>
	@endif

</body>

</html>
<link rel="stylesheet" href="/css/cropper.min.css">
<script src="/js/jquery.min.js"></script>
<script src="/js/cropper.min.js"></script>
<script src="/js/img_preview.js"></script>
<script src="/js/wangEditor.min.js"></script>
<script>
	var x = $("input[name=x]");
	var y = $("input[name=y]");
	var w = $("input[name=w]");
	var h = $("input[name=h]");
	// 裁切
    // 选中图片
    var $image = $('#image');
    $("#logo").change(function(){
        var url = getObjectUrl( this.files[0] )    
        // 把图片的地址设置到 img 标签的 src 属性上
        $image.attr('src', url)

        // 先消毁原插件 
        $image.cropper("destroy")
        /* 启动 cropper 插件 */
        $image.cropper({
            aspectRatio: 1,                              // 缩略图1:1的比例
            preview:'.img-preview',                      // 显示缩略图的框
            viewMode:3,                                  // 显示模式
            // 裁切时触发事件
            crop: function(event) {
                x.val(event.detail.x);             // 裁切区域左上角x坐标
                y.val(event.detail.y);             // 裁切区域左上角y坐标
                w.val(event.detail.width);         // 裁切区域宽高
                h.val(event.detail.height);        // 裁切区域高度
            }
        })
	})
	

	var E = window.wangEditor
	var editor = new E('#content')
	editor.customConfig.uploadImgShowBase64 = true   // 使用 base64 保存图片
	var $text1 = $('#text1')
	editor.customConfig.onchange = function (html) {
		// 监控变化，同步更新到 textarea
		$text1.val(html)
	}
	editor.create()
	// 初始化 textarea 的值
	$text1.val(editor.txt.html())
		

    $("#btn-sku").click(function(){
        var html = `<hr><table width="100%"><tbody>
                    <tr>
                        <td class="label">SKU名称:</td>
                        <td>
                            <input type='text' size="80" name='sku_name[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">库存量:</td>
                        <td>
                            <input type='text' size="80" name='stock[]'>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">价格:</td>
                        <td>
                            ￥ <input type='text' size="10" name='price[]'> 元
                            <font color="red">*</font>
                        </td>
                    </tr></tr><tr>
                        <td class="label"></td>
                        <td>
                            <input onclick="del_attr(this)" type="button" value="删除">
                        </td>
                    </tr>
                    </tbody></table>`;
        $("#sku-container").append(html);
    })
    $("#btn-image").click(function(){
        var html = `<hr><table width="100%"><tbody>
                    <tr>
                        <td class="label"></td>
                        <td>
                            <input class="preview" type='file' name='image[]'>
                            <font color="red">*</font>
                        </td>
                    </tr><tr>
                        <td class="label"></td>
                        <td>
                            <input onclick="del_attr(this)" type="button" value="删除">
                        </td>
                    </tr>
                    </tbody></table>`;
        
        $("#image-container").append(html);
        // 绑定预览事件
        $(".preview").change(function(){
            // 获取选择的图片
            var file = this.files[0];
            // 转成字符串
            var str = getObjectUrl(file);
            // 先删除上一个
            $(this).prev('.img_preview').remove();
            // 在框的前面放一个图片
            $(this).before("<div class='img_preview'><img src='"+str+"' width='120' height='120'></div>");
        });
    })
    $("select[name=cat1_id]").change(function () {
        var id = $(this).val();
        if (id != "") {
            $.ajax({
                type: "GET",
                url: "/goods/ajax_get_cat?id=" + id,
                dataType: "json",
                success: function (data) {
                    var str = "";
                    for (var i = 0; i < data.length; i++) {
                        str += '<option value="' + data[i].id + '">' + data[i].cat_name + '</option>';
                    }
                    // 把拼好的 option 放到第二个下拉框中
                    $("select[name=cat2_id]").html(str)
                    // 触发第二个框的 change 事件
                    $("select[name=cat2_id]").trigger('change');
                }
            })
        } else {
            $("select[name=cat2_id]").html("")
            $("select[name=cat3_id]").html("")
        }
    })
    $("select[name=cat2_id]").change(function () {
        // 取出这个分类的id
        var id = $(this).val()
        // 如果不为空就执行AJAX
        if (id != "") {
            $.ajax({
                type: "GET",
                url: "/goods/ajax_get_cat?id=" + id,
                dataType: "json",
                success: function (data) {
                    var str = "";
                    for (var i = 0; i < data.length; i++) {
                        str += '<option value="' + data[i].id + '">' + data[i].cat_name + '</option>';
                    }
                    // 把拼好的 option 放到第三个下拉框中
                    $("select[name=cat3_id]").html(str)
                }
            });
        }
	});
	
	// 触发第一个框的 change 事件
	$("select[name=cat1_id]").trigger('change');

    var attrStr = `<hr><table width="100%"><tbody>
                <tr>
                    <td class="label">属性名称:</td>
                    <td>
                        <input type='text' size="80" name='attr_name[]'>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label">属性值:</td>
                    <td>
                        <input type='text' size="80" name='attr_value[]'>
                        <font color="red">*</font>
                    </td>
                </tr>
                <tr>
                    <td class="label"></td>
                    <td>
                        <input onclick="del_attr(this)" type="button" value="删除">
                    </td>
                </tr>
            </tbody></table>`;
    
    // 为按钮绑定事件
    $("#btn-attr").click(function(){
        // 将字符串追回到页面中
        $("#attr-container").append(attrStr);
    })
    // 为删除按钮绑定事件
    function del_attr(o){
    
        if(confirm("确定要删除吗？")){
            var table = $(o).parent().parent().parent().parent();
            table.prev("hr").remove();
            table.remove();
        }
    }
</script>