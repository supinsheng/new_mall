<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Privilege;

class PrivilegeController extends Controller
{
    public function index(){

        $model = new Privilege;
        $pris = $model->getPris();

        return view('admin.privilege.index',['pris'=>$pris]);
    }

    // 添加权限
    public function savePri(Request $req){

        $model = new Privilege;
        return $model->savePri($req);
    }

    // Ajax 获取权限
    public function getPriByAjax(){

        $model = new Privilege;
        echo json_encode($model->getPriByAjax());
        
    }

    // 修改权限
    // public function editPri(){
    //     $model = new Privilege;
    //     return $model->editPri();
    // }

    // 删除权限
    public function delPri(){
        $model = new Privilege;
        return $model->delPri();
    }
}
