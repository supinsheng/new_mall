<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Privilege;
use App\Model\Role;

class RoleController extends Controller
{
    public function index(){

        $model = new Privilege;
        $pris = $model->getPris();
        $model = new Role;
        $roles = $model->getRoles();
        
        return view('admin.role.index',['pris'=>$pris,'roles'=>$roles]);
    }

    // 添加角色
    public function saveRole(){
        
        $model = new Role;
        return $model->saveRole();
    }

    // Ajax 获取角色
    public function getRoleByAjax(){
        $model = new Role;
        echo json_encode($model->getRoleByAjax());
    }

    // 修改角色
    public function editRole(){
        $model = new Role;
        return $model->editRole();
    }

    // 删除角色
    public function delRole(){
        $id = $_GET['id'];
        $model = new Role;
        return $model->delRole($id);
    }
}
