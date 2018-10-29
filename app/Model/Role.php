<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
{
    // 获取所有的角色
    public function getRoles(){

        return DB::table('role')->select('role.*',DB::raw("GROUP_CONCAT(nm_privilege.pri_name) pri_name"),DB::raw("GROUP_CONCAT(nm_privilege.url_path) url_path"))
                        ->leftJoin('role_privilege','role.id','role_privilege.role_id')
                        ->leftJoin('privilege','role_privilege.pri_id','privilege.id')
                        ->groupBy('role.id')
                        ->orderBy('id','asc')
                        ->get();
    }

    // Ajax 获取角色
    public function getRoleByAjax(){

        return DB::table('role')->select('role.*',DB::raw("GROUP_CONCAT(nm_role_privilege.pri_id) pri_id"))
                        ->leftJoin('role_privilege','role.id','role_privilege.role_id')
                        ->where('id',$_GET['id'])
                        ->groupBy('role.id')
                        ->get();
    }

    // 添加角色
    public function saveRole(){
        
        if($_POST['role_name'] == '' || !isset($_POST['pri_id'])){
            return back()->with('status','添加失败！数据不完整');
        }

        $id = DB::table('role')->insertGetId([
            'role_name'=>$_POST['role_name']
        ]);
        
        foreach($_POST['pri_id'] as $pri_id){
            
            DB::table('role_privilege')->insert([
                'role_id'=>$id,
                'pri_id'=>$pri_id
            ]);
        }
        return back()->with('status','添加成功！');
    }

    // 修改角色
    public function editRole(){

        if($_POST['role_name'] == '' || !isset($_POST['pri_id'])){
            return back()->with('status','修改失败！数据不能为空！');
        }

        DB::table('role')->where('id',$_GET['id'])->update([
            'role_name'=>$_POST['role_name']
        ]);

        // 先删除角色原来的权限，然后再重新给角色添加权限
        DB::table('role_privilege')->where('role_id',$_GET['id'])->delete();
        foreach($_POST['pri_id'] as $pri_id){
            
            DB::table('role_privilege')->insert([
                'role_id'=>$_GET['id'],
                'pri_id'=>$pri_id
            ]);
        }
        return back()->with('status','修改成功！');
    }

    // 删除角色
    public function delRole($id){
        $admins = DB::table('admin_role')->select('admin_id')->where('role_id',$id)->get();

        if(isset($admins[0]->admin_id)){
            
            foreach($admins as $admin){
                DB::table('admin')->where('id',$admin->admin_id)->delete();
                DB::table('admin_role')->where('admin_id',$admin->admin_id)->delete();
            }
        }

        DB::table('role')->where('id',$id)->delete();
        DB::table('role_privilege')->where('role_id',$id)->delete();
        
        DB::table('admin_role')->where('role_id',$id)->delete();
    
        return back()->with('status','删除成功！');
    }
}
