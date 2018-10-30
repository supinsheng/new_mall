﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>商城后台登录</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/css/login2.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <h1>商城后台登录</h1>

    <div class="login" style="margin-top:50px;">

        <div class="header">
            <div class="switch" id="switch"><a class="switch_btn_focus" id="switch_qlogin" href="javascript:void(0);"
                    tabindex="7">后台登录</a>
            </div>
        </div>


        <div class="web_qr_login" id="web_qr_login" style="display: block; height: 235px;">

            <!--登录-->
            <div class="web_login" id="web_login">
                <div class="login-box">
                    <div class="login_form">
                        <form action="/admin/doLogin" name="loginform" accept-charset="utf-8" id="login_form" class="loginForm"
                            method="post"><input type="hidden" name="did" value="0" />
                            @csrf
                            <input type="hidden" name="to" value="log" />
                            <div class="uinArea" id="uinArea">
                                <label class="input-tips" for="u">帐号：</label>
                                <div class="inputOuter" id="uArea">

                                    <input type="text" id="u" name="username" class="inputstyle" />
                                </div>
                            </div>
                            <div class="pwdArea" id="pwdArea">
                                <label class="input-tips" for="p">密码：</label>
                                <div class="inputOuter" id="pArea">

                                    <input type="password" id="p" name="password" class="inputstyle" />
                                </div>
                            </div>

                            <div style="padding-left:50px;margin-top:20px;"><input type="submit" value="登 录" style="width:150px;"
                                    class="button_blue" /></div>
                        </form>
                    </div>

                </div>

            </div>
            <!--登录end-->
        </div>
    </div>
</body>
@if (session('status'))
    <script>alert( '{{ session('status') }}');</script>
@endif
</html>