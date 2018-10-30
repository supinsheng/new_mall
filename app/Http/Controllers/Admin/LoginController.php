<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class LoginController extends Controller
{
    // 登录页
    public function login(){
        return view('admin.login.login');
    }

    // 处理登录
    public function doLogin(Request $req){

        $user = DB::table('admin')->where('username',$req->username)->first();
        if($user){
            if($user->password == md5($req->password)){

                session(['admin_id'=>$user->id,'username'=>$user->username]);
                $admin = DB::table('admin_role')->where([
                    ['role_id','1'],
                    ['admin_id',$user->id]
                ])->get();
                if(count($admin)>0){
                    session(['root'=>true]);
                }else {
                    $data = DB::table('admin_role')->select('privilege.url_path')
                                        ->leftJoin('role_privilege','admin_role.role_id','role_privilege.role_id')
                                        ->leftJoin('privilege','role_privilege.pri_id','privilege.id')
                                        ->where([
                                            ['admin_role.admin_id',$user->id],
                                            ['privilege.url_path','!=','']
                                        ])->get();
                    $_ret = [];
                    foreach($data as $v){
                        if(FALSE === strpos($v->url_path,',')){
                            $_ret[] = $v->url_path;
                        }else {
                            $_tt = explode(',',$v->url_path);
                            $_ret = array_merge($_ret,$_tt);
                        }
                    }
                    session(['url_path'=>$_ret]);
                }
                return redirect('/admin/index')->with('status','登录成功！');
            }else {
                return back()->with('status','密码不正确！');
            }
        }else {
            return back()->with('status','管理员不存在！');
        }
    }

    // 退出登录
    public function logout(Request $request){
        $request->session()->forget('admin_id');
        $request->session()->forget('username');
        $request->session()->forget('root');
        $request->session()->forget('url_path');
        return redirect('/admin/login')->with('status','退出成功！');
    }
}