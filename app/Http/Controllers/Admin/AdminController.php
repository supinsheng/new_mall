<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Admin;

class AdminController extends Controller
{
    public function index(){
        $model = new Role;
        $roles = $model->getRoles();
        $model = new Admin;
        $admins = $model->getAdmins();
        return view('admin.admin.index',['roles'=>$roles,'admins'=>$admins]);
    }

    // 添加管理员
    public function saveAdmin(){
        $model = new Admin();
        return $model->saveAdmin();
    }

    // Ajax 获取管理员
    public function getAdminByAjax(){
        $model = new Admin;
        echo json_encode($model->getAdminByAjax());
    }

    // 修改管理员
    public function editAdmin(){
        $model = new Admin;
        return $model->editAdmin();
    }

    // 删除管理员
    public function delAdmin(){
        $model = new Admin;
        return $model->delAdmin();
    }
}
