<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Article extends Model
{
    // Ajax 获取分类
    public function getArticleCatByAjax(){

        return DB::table('article_category')->where('id',$_GET['id'])->first();
    }

    // 添加文章
    public function insert($req){

        if($req->title){
            if($req->content == '<p><br></p>'){
                return back()->with('status','添加失败！内容不能为空！');
            }
            if($req->link){
                $link = $req->link;
            }else {
                $link = '';
            }

            DB::table('article')->insert([
                'title'=>$req->title,
                'content'=>$req->content,
                'link'=>$link,
                'cat_id'=>$req->cat_id
            ]);
            return redirect('/admin/article')->with('status','添加成功！');
        }else {
            return back()->with('status','添加失败！标题不能为空！');
        }
    }

    // 修改文章
    public function doEdit($req){
        
        if($req->title){
            if($req->content == '<p><br></p>'){
                return back()->with('status','修改失败！内容不能为空！');
            }
            if($req->link){
                $link = $req->link;
            }else {
                $link = '';
            }
            DB::table('article')->where('id',$_GET['id'])->update([
                'title'=>$req->title,
                'content'=>$req->content,
                'link'=>$link,
                'cat_id'=>$req->cat_id
            ]);
            return redirect('/admin/article')->with('status','修改成功！');
        }else {
            return back()->with('status','修改失败！标题不能为空！');
        }
    }
}
