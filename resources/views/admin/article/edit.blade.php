<!doctype html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/css/main1.css"/>
</head>
<body>

<div class="container clearfix">
    
    <!--/sidebar-->
    <div>

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><span class="crumb-step"><</span><a class="crumb-name" href="/admin/article">返回</a></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/article/doEdit?id={{ $article->id }}" method="post" id="myform" name="myform" enctype="multipart/form-data">
                    @csrf
                    <table class="insert-tab" width="100%">
                        <tbody><tr>
                            <th width="120"><i class="require-red">*</i>分类：</th>
                            <td>
                                <select name="cat_id" id="catid" class="required">
                                    @foreach($cats as $cat)
                                    <option @if($article->cat_id == $cat->id) echo selected @endif value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                            <tr>
                                <th><i class="require-red">*</i>标题：</th>
                                <td>
                                    <input class="common-text required" id="title" name="title" size="50" value="{{ $article->title }}" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th>跳转的地址：</th>
                                <td><input class="common-text" name="link" size="50" value="{{ $article->link }}" type="text" placeholder="若不需要跳转，可以不填"></td>
                            </tr>
                           
                            <tr>
                                <th>内容：</th>
                                <td id="content">
                                    <?=$article->content?>
                                </td>
                                <textarea id="text1" style="display:none" name="content"></textarea>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                                    <input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody></table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
@if (session('status'))
    <script>alert( '{{ session('status') }}');</script>
@endif
</body>
</html>
<script src="/js/jquery.min.js"></script>
<script src="/js/wangEditor.min.js"></script>
<script>
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
</script>