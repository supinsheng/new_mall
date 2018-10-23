<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    public function ad_category(){

        return view('admin.ad.ad_category');
    }

    public function ad(){

        return view('admin.ad.ad');
    }
}
