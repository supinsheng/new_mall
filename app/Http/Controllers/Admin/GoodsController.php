<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Uploader;
use DB;
use App\Model\Brand;
use App\Model\GoodsCat;
use App\Model\Goods;

class GoodsController extends Controller
{
    public function brand(){

        $brands = DB::table('brand')->paginate(2);

        // echo "<pre>";
        // var_dump($brands[0]->brand_name);
        // exit;

        return view('admin.goods.brand',['brands'=>$brands]);
    }

    // 根据Ajax获取数据
    public function getBrandByAjax(){

        $id = $_GET['id'];
        $brand = DB::table('brand')->where('id',$id)->first();

        echo json_encode($brand);
    }

    public function specification(){

        return view('admin.goods.specification');
    }

    public function type_template(){

        return view('admin.goods.type_template');
    }

    public function item_cat(){

        $cats = DB::table('goods_category')
                    ->select(DB::raw("*,CONCAT(path,id,'-')"))
                    ->orderByRaw("CONCAT(path,id,'-') asc")
                    ->get();

        return view('admin.goods.item_cat',['cats'=>$cats]);
    }

    public function getCatByAjax(){

        $id = $_GET['id'];
        $cat = DB::table('goods_category')->where('id',$id)->first();

        echo json_encode($cat);
    }

    public function goods(){

        $model = new Goods;
        $goods = $model->getGoods();
        return view('admin.goods.goods',['goods'=>$goods]);
    }

    // 保存商品品牌
    public function saveBrand(){

        $model = new Brand;
        return $model->saveBrand();
    }

    // 修改商品品牌
    public function editBrand(){

        $id = $_GET['id'];
        $model = new Brand;
        return $model->editBrand($id,$_POST);
    }

    // 删除商品品牌
    public function delBrand(){

        $id = $_GET['id'];
        $model = new Brand;
        return $model->delBrand($id);
    }

    // 添加商品分类
    public function saveCat(Request $req){

        $model = new GoodsCat;
        return $model->saveCat($req); 
    }

    // 修改商品分类
    public function editCat(Request $req){

        $id = $_GET['id'];
        $model = new GoodsCat;
        return $model->editCat($id,$req);
    }

    // 删除商品分类
    public function delCat(){

        $id = $_GET['id'];
        $model = new GoodsCat;
        return $model->delCat($id);
    }

    // 添加商品
    public function add(){

        $model = new GoodsCat;
        $topCats = $model->getCatByPid();

        $model = new Brand;
        $brands = $model->getBrand();

        return view('admin.goods.add',['topCats'=>$topCats,'brands'=>$brands]);
    }

    // ajax根据父级id获取分类
    public function ajax_get_cat(){

        $parent_id = $_GET['id'];
        $model = new GoodsCat;
        echo $model->getCatByPid($parent_id);
    }

    // 执行商品添加
    public function insert(Request $req){

        $model = new Goods;
        return $model->insert($req);
    }

    // 编辑商品
    public function edit(){

        $model = new GoodsCat;
        $topCats = $model->getCatByPid();
        $model = new Brand;
        $brands = $model->getBrand();

        $model = new Goods;
        $data = $model->getFullInfo($_GET['id']);

        return view('admin.goods.edit',['topCats'=>$topCats,'brands'=>$brands,'data'=>$data]);
    }

    // 执行商品修改
    public function doEdit(Request $req){
        
        $model = new Goods;
        return $model->doEdit($req);
    }

    // 删除商品
    public function delGood(){
        $id = $_GET['id'];
        $model = new Goods;
        return $model->delGood($id);
    }
}
