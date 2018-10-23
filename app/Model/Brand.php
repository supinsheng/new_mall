<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Uploader;
use DB;

class Brand extends Model
{
    // 保存商品品牌
    public function saveBrand(){

        $upload = Uploader::make();
        $logo = '/uploads/'.$upload->upload('logo','brand');

        $num = DB::insert('INSERT INTO nm_brand(brand_name,logo) VALUES(?,?)',[$_POST['brand_name'],$logo]);
       
        if($num){
            return redirect('/admin/brand')->with('status', '保存成功！');
        }
    }

    // 编辑商品品牌
    public function editBrand($id,$data){

        $results = DB::table('brand')->where('id',$id)->first();
        
        if($_FILES['logo']['error'] == 0){

            @unlink(ROOT.'/public/'.$results->logo);

            $upload = Uploader::make();
            $logo = '/uploads/'.$upload->upload('logo','brand');
        }else {

            $logo = $results->logo;
        }

        $num = DB::table('brand')->where('id',$id)->update(['brand_name'=>$data['brand_name'],'logo'=>$logo]);

        if($num!=0){

            return redirect('/admin/brand')->with('status', '修改成功！');
        }else {

            return back()->with('status', '图片有误！');
        }
    }

    // 删除商品品牌
    public function delBrand(){

        $path = DB::table('brand')->where('id',$id)->value('logo');
        @unlink(ROOT.'/public/'.$path);

        if(DB::table('brand')->where('id',$id)->delete()){

            return redirect('/admin/brand')->with('status', '删除成功！');
        }else {

            return back()->with('status', '删除失败！');
        }
    }
}