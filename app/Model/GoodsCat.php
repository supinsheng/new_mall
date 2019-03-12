<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Model\Goods;

class GoodsCat extends Model
{
    protected $table = 'goods_category';
    public $timestamps = false;

    public function subMenuLevel2() {
        return $this->hasMany('App\Model\GoodsCat','parent_id','id')
            ->select(['id','cat_name','parent_id']);
    }

    public function subMenuLevel1() {
        return $this->hasMany('App\Model\GoodsCat','parent_id','id')
            ->select(['id','cat_name','parent_id'])
            ->with('subMenuLevel2');
    }


    public static function getCategoryMenu() {
        return GoodsCat::where('parent_id',0)
            ->with('subMenuLevel1')
            ->get(['id','cat_name']);
    }
    // 添加商品分类
    public function saveCat($req){

        if($req->cat_name == null){
            return back()->with('status','添加失败！数据填写不完整！');
        }

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
        $childrens = DB::table('goods_category')->where('parent_id',$id)->get();
        if(count($childrens)>0){
            foreach($childrens as $children){
                DB::table('goods_category')->where('id',$children->id)->delete();
                DB::table('goods_category')->where('parent_id',$children->id)->delete();
            }
        }
        
        if($num){

            $model = new Goods;
            $ids = DB::table('goods')->where('cat1_id',$id)->orWhere('cat2_id',$id)->orWhere('cat3_id',$id)->pluck('id');
            if(count($ids)>0){
                foreach($ids as $id){
                    $model->delGood($id);
                }
            }

            return redirect('/admin/item_cat')->with('status', '删除成功！');
        }else {
            return back()->with('status', '删除失败！');
        }
    }

    // 根据父级id获取商品分类
    public function getCatByPid($parent_id=0){

        $cats = DB::table('goods_category')->where('parent_id',$parent_id)->get();
        return $cats;
    }
}
