<?php

namespace App\Http\Controllers\Home;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsCat;

class IndexController extends Controller
{
    // 首页
    public function index(){

        // $results = DB::select('SHOW FULL FIELDS FROM nm_admin');
        // echo "<pre>";
        // var_dump($results);
        // exit;
        $model = new GoodsCat;
        $data = $model->getCategoryMenu();

        return view('home.index.index',['data'=>$data]);
    }

    // 商品列表页
    public function search(){

        // dd($_SERVER);   

        $cat_id = $_GET['id'];
        if(isset($_GET['brand_id'])){

            $goods = DB::table('goods')->where('cat1_id',$cat_id)
                        ->orWhere('cat2_id',$cat_id)
                        ->orWhere('cat3_id',$cat_id)
                        ->where('brand_id',$_GET['brand_id'])
                        ->get(); 
        }else {

            $goods = DB::table('goods')->where('cat1_id',$cat_id)
                        ->orWhere('cat2_id',$cat_id)
                        ->orWhere('cat3_id',$cat_id)
                        ->get();
        }
        
        $brands = DB::table('brand')->select('brand.*')
                                ->leftJoin('goods','brand.id','goods.brand_id')
                                ->where('cat1_id',$cat_id)
                                ->orWhere('cat2_id',$cat_id)
                                ->orWhere('cat3_id',$cat_id)
                                ->groupBy('brand.id')
                                ->get();

        return view('home/index.search',['goods'=>$goods,'brands'=>$brands,'cat_id'=>$cat_id]);
    }

    // 商品详情页
    public function item(){

        $good = DB::table('goods')->where('id',$_GET['id'])->first();
        $images = DB::table('goods_image')->where('goods_id',$_GET['id'])->get();
        $skus = DB::table('goods_sku')->where('goods_id',$_GET['id'])->get();
    
        return view('home.index.item',['good'=>$good,'images'=>$images,'skus'=>$skus]);
    }
}