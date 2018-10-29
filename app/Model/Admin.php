<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Admin extends Model
{
    // 获取管理员
    public function getAdmins(){

        return DB::table('admin')->select('admin.*',DB::raw('GROUP_CONCAT(nm_role.role_name) role_name'))
                            ->leftJoin('admin_role','admin.id','admin_role.admin_id')
                            ->leftJoin('role','admin_role.role_id','role.id')
                            ->orderBy('admin.id','asc')
                            ->groupBy('admin.id')
                            ->get();
    }

    // 添加管理员
    public function saveAdmin(){

        if($_POST['username'] == '' || $_POST['password'] == '' || !isset($_POST['role_id'])){
            return back()->with('status','添加失败！数据填写不完整！');
        }
        $id = DB::table('admin')->insertGetId([
            'username'=>$_POST['username'],
            'password'=>md5($_POST['password'])
        ]);

        foreach($_POST['role_id'] as $role_id){
            DB::table('admin_role')->insert([
                'admin_id'=>$id,
                'role_id'=>$role_id
            ]);
        }

        return back()->with('status','添加成功！');
    }

    // Ajax 获取管理员
    public function getAdminByAjax(){

        return DB::table('admin')->select('admin.*',DB::raw('GROUP_CONCAT(nm_admin_role.role_id) role_id'))
                            ->leftJoin('admin_role','admin.id','admin_role.admin_id')
                            ->where('admin.id',$_GET['id'])
                            ->groupBy('admin.id')
                            ->get();
    }

    // 修改管理员
    public function editAdmin(){
        if($_POST['username'] == '' || $_POST['password'] == '' || !isset($_POST['role_id'])){
            return back()->with('status','修改失败！数据不完整！'); 
        }

        $admin = DB::table('admin')->where('id',$_GET['id'])->first();
        if($_POST['password'] == $admin->password){
            $password = $_POST['password'];
        }else {
            $password = md5($_POST['password']);
        }

        DB::table('admin')->where('id',$_GET['id'])->update([
            'username'=>$_POST['username'],
            'password'=>$password
        ]);

        DB::table('admin_role')->where('admin_id',$_GET['id'])->delete();
        foreach($_POST['role_id'] as $role_id){
            DB::table('admin_role')->insert([
                'admin_id'=>$_GET['id'],
                'role_id'=>$role_id
            ]);
        }

        return back()->with('status','修改成功！');
    }

    // 删除管理员
    public function delAdmin(){

        DB::table('admin')->where('id',$_GET['id'])->delete();
        DB::table('admin_role')->where('admin_id',$_GET['id'])->delete();

        return back()->with('status','删除成功！');
    }
}
