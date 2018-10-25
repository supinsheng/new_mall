<?php

namespace App\Model;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Uploader;
use DB;

class Goods extends Model
{
    protected $table = 'goods';
    public $timestamps = false;
    // 钩子函数
    private function _before_write($req){

        if($_FILES['logo']['error'] == 0){

            $x = $req->x;
            $y = $req->y;
            $w = $req->w;
            $h = $req->h;

            $upload = Uploader::make();
            $logo = '/uploads/'.$upload->upload('logo','goods');
            
            $image = Image::make(ROOT.'/public/'.$logo);
            $image->crop((int)$w,(int)$h,(int)$x,(int)$y);
            $image->resize(400,400);
            $image->save($image->dirname.'/bg_'.$image->basename);
            $bg_logo = '/uploads/goods/'.date("Ymd").'/'.$image->basename;

            $image = Image::make(ROOT.'/public/'.$logo);
            $image->crop((int)$w,(int)$h,(int)$x,(int)$y);
            $image->resize(220,220);
            $image->save($image->dirname.'/md_'.$image->basename);
            $md_logo = '/uploads/goods/'.date("Ymd").'/'.$image->basename;

            $image = Image::make(ROOT.'/public/'.$logo);
            $image->crop((int)$w,(int)$h,(int)$x,(int)$y);
            $image->resize(56,56);
            $image->save($image->dirname.'/sm_'.$image->basename);
            $sm_logo = '/uploads/goods/'.date("Ymd").'/'.$image->basename;

            return [
                'logo'=>$logo,
                'bg_logo'=>$bg_logo,
                'md_logo'=>$md_logo,
                'sm_logo'=>$sm_logo,
            ];
        }else {
            return FALSE;
        }
    }

    // 获取商品
    public function getGoods(){

        $goods = DB::table('goods')->select("goods.*","brand.brand_name",DB::raw("GROUP_CONCAT(nm_goods_category.cat_name) cat_name"))
                        ->leftJoin('goods_category',function($join){
                            $join->on('goods_category.id','=','goods.cat1_id')
                                    ->orOn('goods_category.id','=','goods.cat2_id')
                                    ->orOn('goods_category.id','=','goods.cat3_id');
                        })
                        ->leftJoin('brand','goods.brand_id','brand.id')
                        ->groupBy('goods.id')->paginate(1);

        return $goods;
    }
    
    // 添加商品
    public function insert($req){
        
        $logo = $this->_before_write($req);

        if($logo===FALSE){
            return back()->with('status','添加失败，数据填写不完整！');
        }

        if($req->goods_name != ''){

            $id = DB::table('goods')->insertGetId([
                'goods_name'=>$req->goods_name,
                'describe'=>$req->describe,
                'logo'=>$logo['logo'],
                'sm_logo'=>$logo['sm_logo'],
                'md_logo'=>$logo['md_logo'],
                'bg_logo'=>$logo['bg_logo'],
                'cat1_id'=>$req->cat1_id,
                'cat2_id'=>$req->cat2_id,
                'cat3_id'=>$req->cat3_id,
                'brand_id'=>$req->brand_id,
                'is_on_sale'=>$req->is_on_sale
            ]);
    
            if($id){
                $req->id = $id;
                if($this->_after_write($req)===FALSE){
                    return back()->with('status', '添加失败，数据填写不完整！');
                }

                return redirect('/admin/goods')->with('status', '添加成功！');
            }else {
                return back()->with('status', '添加失败，数据填写不完整！');
            }
        }else {
            return back()->with('status', '添加失败，数据填写不完整！');
        }
    }

    private function _after_write($req){
        
        // 添加商品属性
        $goodsId = isset($_GET['id']) ? $_GET['id'] : $req->id;
        // 先删除之前的属性
        DB::table('goods_attribute')->where('goods_id',$goodsId)->delete();
        // dd($req->attr_name);
        if(isset($req->attr_name)){
            
            if($req->attr_name[0] == null || $req->attr_value[0] == null){
                return FALSE;
            }
            foreach($req->attr_name as $k=>$v){
    
                DB::table('goods_attribute')->insert([
                    'attr_name'=>$v,
                    'attr_value'=>$req->attr_value[$k],
                    'goods_id'=>$goodsId
                ]);
            }
        }


        // 添加商品SKU
        // 先删除之前的SKU
        DB::table('goods_sku')->where('goods_id',$goodsId)->delete();

        if(isset($req->sku_name)){

            if($req->sku_name[0] == null || $req->stock[0] == null || $req->price[0] == null){
                return FALSE;
            }
            foreach($req->sku_name as $k=>$v){
    
                DB::table('goods_sku')->insert([
                    'sku_name'=>$v,
                    'stock'=>$req->stock[$k],
                    'price'=>$req->price[$k],
                    'goods_id'=>$goodsId
                ]);
            }
        }


        // 如果有要删除的图片，那就删除
        if(isset($req->del_image) && $req->del_image != ''){
            // 先根据ID把图片路径取出来
            $path = DB::table('goods_image')->whereIn('id',explode(',',$req->del_image))->get();
            foreach($path as $v){
                @unlink(ROOT.'/public'.$v->path);
            }
            DB::table('goods_image')->whereIn('id',explode(',',$req->del_image))->delete();
        }
        
        // 添加商品图片
        if(isset($_FILES['image'])){

            if($_FILES['image']['error'][0] == 0){
            
                $upload = Uploader::make();
                $tmp = [];
    
                foreach($_FILES['image']['name'] as $k=>$v){
                    $tmp['name'] = $v;
                    $tmp['type'] = $_FILES['image']['type'][$k];
                    $tmp['tmp_name'] = $_FILES['image']['tmp_name'][$k];
                    $tmp['error'] = $_FILES['image']['error'][$k];
                    $tmp['size'] = $_FILES['image']['size'][$k];
                    $_FILES['tmp'] = $tmp;
                    $path = $upload->upload('tmp','goods_images');
                    $path = '/uploads/'.$path;
                    
                    DB::table('goods_image')->insert([
                        'path'=>$path,
                        'goods_id'=>$goodsId
                    ]);
                }
            }else {
                return FALSE;
            }
        }
        
    }


    // 获取商品所有的信息
    public function getFullInfo($id){
        
        // 获取商品基本信息
        $info = DB::table('goods')->where('id',$id)->first();
        // 获取商品属性信息
        $attrs = DB::table('goods_attribute')->where('goods_id',$id)->get();
        // 获取商品图片
        $images = DB::table('goods_image')->where('goods_id',$id)->get();
        // 获取商品SKU
        $skus = DB::table('goods_sku')->where('goods_id',$id)->get();

        return [
            'info'=>$info,
            'images'=>$images,
            'skus'=>$skus,
            'attrs'=>$attrs
        ];
    }

    // 执行编辑
    public function doEdit($req){

        if($req->goods_name != null){

            $good = Goods::find($_GET['id']);
            
            $logo = $this->_before_write($req);
            if($logo !== FALSE){
                @unlink(ROOT.'/public'.$good->logo);
                @unlink(ROOT.'/public'.$good->sm_logo);
                @unlink(ROOT.'/public'.$good->md_logo);
                @unlink(ROOT.'/public'.$good->bg_logo);

                $good->logo = $logo['logo'];
                $good->sm_logo = $logo['sm_logo'];
                $good->md_logo = $logo['md_logo'];
                $good->bg_logo = $logo['bg_logo'];

            }

            $good->goods_name = $req->goods_name;
            $good->describe = $req->describe;
            $good->cat1_id = $req->cat1_id;
            $good->cat2_id = $req->cat2_id;
            $good->cat3_id = $req->cat3_id;
            $good->brand_id = $req->brand_id;
            $good->is_on_sale = $req->is_on_sale;

            if($good->save()){

                $this->_after_write($req);
                return redirect('/admin/goods')->with('status', '修改成功！');
            }else {
                return back()->with('status','修改失败！');
            }

        }else {
            return back()->with('status','修改失败，数据填写不完整！');
        }
    }
}
