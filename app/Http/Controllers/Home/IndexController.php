<?php

namespace App\Http\Controllers\Home;
use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(){

        // $results = DB::select('SHOW FULL FIELDS FROM nm_admin');
        // echo "<pre>";
        // var_dump($results);
        // exit;
        return view('home.index.index');
    }
}
