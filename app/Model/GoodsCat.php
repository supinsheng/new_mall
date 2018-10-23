<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class GoodsCat extends Model
{
    // 添加商品分类
    public function saveCat($req){

        $data = explode('|',$req->parent_id);
        
        if(count($data)==2){
            $parent_id = $data[0];
            $path = $data[1].$data[0].'-';
        }else {
            $parent_id = '0';
            $path = '-';
        }

        $num = DB::table('goods_category')->insert(['cat_name'=>$req->cat_name,'parent_id'=>$parent_id,'path'=>$path]);

        if($num){
            return redirect('/admin/item_cat')->with('status', '添加成功！');
        }
    }

    // 编辑商品分类
    public function editCat($id,$req){

        $data = explode('|',$req->parent_id);

        if(count($data) == 2){
            $parent_id = $data[0];
            $path = $data[1].$parent_id.'-';
        }else {
            $parent_id = '0';
            $path = '-';
        }
        
        // dd($data);
        // exit;
        
        $num = DB::table('goods_category')->where('id',$id)->update(['cat_name'=>$req->cat_name,'parent_id'=>$parent_id,'path'=>$path]);

        if($num){

            return redirect('/admin/item_cat')->with('status', '修改成功！');
        }else {

            return back()->with('status', '修改失败！');
        }
    }

    // 删除商品分类
    public function delCat($id){

        $num = DB::table('goods_category')->where('id',$id)->delete();
        if($num){

            return redirect('/admin/item_cat')->with('status', '删除成功！');
        }else {
            return back()->with('status', '删除失败！');
        }
    }
}
