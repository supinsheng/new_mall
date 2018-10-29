<?php

namespace App\Model;
use DB;
use App\Model\Role;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    // 获取权限
    public function getPris(){

        return DB::table('privilege')->get();
    }

    // 添加权限
    public function savePri($req){
        // dd($req->url_path);

        if($req->pri_name == null || $req->url_path == null){
            return back()->with('status','添加失败！数据填写不完整！');
        }

        if(DB::table('privilege')->insert([
            'pri_name'=>$req->pri_name,
            'url_path'=>$req->url_path,
        ])){
            return back()->with('status','权限添加成功！');
        }else {
            return back()->with('status','权限添加失败！');
        }
    }

    // Ajax 获取权限
    public function getPriByAjax(){
        return DB::table('privilege')->where('id',$_GET['id'])->first();
    }

    // 修改权限
    // public function editPri(){
    //     if($_POST['pri_name'] == '' || $_POST['url_path'] == ''){
    //         return back()->with('status','修改失败！数据不能为空！');
    //     }
    //     if(DB::table('privilege')->where('id',$_GET['id'])->update([
    //         'pri_name'=>$_POST['pri_name'],
    //         'url_path'=>$_POST['url_path']
    //     ])){
    //         return back()->with('status','修改成功！');
    //     }
    // }

    // 删除权限
    public function delPri(){
        DB::table('privilege')->where('id',$_GET['id'])->delete();
        $roles = DB::table('role_privilege')->where('pri_id',$_GET['id'])->get();
        DB::table('role_privilege')->where('pri_id',$_GET['id'])->delete();
        if(isset($roles[0]->role_id)){
            foreach($roles as $role){
                DB::table('role')->where('id',$role->role_id)->delete();
                $model = new Role;
                $model->delRole($role->role_id);
            }
        }
        return back()->with('status','删除成功！');
    }
}
