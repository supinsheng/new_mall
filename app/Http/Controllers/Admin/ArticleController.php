<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Article;

class ArticleController extends Controller
{
    public function article(){
        $articles = DB::table('article')->select('article.*','article_category.cat_name')
                            ->leftJoin('article_category','article.cat_id','article_category.id')
                            ->get();
        return view('admin.article.article',['articles'=>$articles]);
    }

    // 添加文章
    public function addArticle(){
        $cats = DB::table('article_category')->get();
        return view('admin.article.create',['cats'=>$cats]);
    }

    public function insert(Request $req){
        
        $model = new Article;
        return $model->insert($req);
    }

    // 修改文章
    public function edit(){

        $article = DB::table('article')->where('id',$_GET['id'])->first();
        $cats = DB::table('article_category')->get();
        return view('admin.article.edit',['article'=>$article,'cats'=>$cats]);
    }

    public function doEdit(Request $req){

        $model = new Article;
        return $model->doEdit($req);
    }

    // 删除文章
    public function delArticle(){
        DB::table('article')->where('id',$_GET['id'])->delete();
        return back()->with('status','删除成功！');
    }

    public function article_cat(){
        $cats = DB::table('article_category')->orderBy('id','asc')->get();
        return view('admin.article.article_cat',['cats'=>$cats]);
    }

    // 添加文章分类
    public function saveArticle_cat(Request $req){
        
        if($req->cat_name){
            DB::table('article_category')->insert(['cat_name'=>$req->cat_name]);
            return back()->with('status','添加分类成功！');
        }else {
            return back()->with('status','添加失败！数据不能为空！');
        }
        
    }

    // Ajax 获取分类
    public function getArticleCatByAjax(){
        
        $model = new Article;
        echo json_encode($model->getArticleCatByAjax());
    }

    // 修改分类
    public function editArticleCat(Request $req){

        if($req->cat_name){
            DB::table('article_category')->where('id',$_GET['id'])->update(['cat_name'=>$req->cat_name]);
            return back()->with('status','修改成功！');
        }else {
            return back()->with('status','修改失败！数据不能为空！');
        }
    }

    // 删除分类
    public function delArticleCat(){
        DB::table('article_category')->where('id',$_GET['id'])->delete();
        return back()->with('status','删除成功！');
    }
}
