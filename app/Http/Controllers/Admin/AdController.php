<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Uploader;
use DB;

class AdController extends Controller
{
    // public function ad_category(){

    //     return view('admin.ad.ad_category');
    // }

    public function ad(){

        $ads = DB::table('ad')->get();

        return view('admin.ad.ad',['ads'=>$ads]);
    }

    // 添加广告
    public function saveAd(Request $req){
        
        if($req->title && $req->link){

            if($_FILES['image']['error'] == 4){
                return back()->with('status','添加失败！图片没有上传！');
            }
            $upload = Uploader::make();
            $image = '/uploads/'.$upload->upload('image','ad');

            DB::table('ad')->insert([
                'title'=>$req->title,
                'link'=>$req->link,
                'is_show'=>$req->is_show,
                'image'=>$image
            ]);

            return back()->with('status','添加成功！');
               
        }else {
            return back()->with('status','添加失败！数据不完整！');
        }
    }

    // Ajax 获取广告
    public function getAdByAjax(){

        $ad = DB::table('ad')->where('id',$_GET['id'])->first();
        echo json_encode($ad);
    }

    // 修改广告
    public function editAd(Request $req){
        // dd($req->all());
        $results = DB::table('ad')->where('id',$_GET['id'])->first();

        if($_FILES['image']['error'] == 0){

            @unlink(ROOT.'/public/'.$results->image);

            $upload = Uploader::make();
            $image = '/uploads/'.$upload->upload('image','ad');
        }else {

            $image = $results->image;
        }

        DB::table('ad')->where('id',$_GET['id'])->update([
            'title'=>$_POST['title'],
            'link'=>$_POST['link'],
            'is_show'=>$_POST['is_show'],
            'image'=>$image
        ]);

        return back()->with('status','修改成功！');
    }

    // 删除广告
    public function delAd(){
        DB::table('ad')->where('id',$_GET['id'])->delete();
        return back()->with('status','删除成功！');
    }
}
