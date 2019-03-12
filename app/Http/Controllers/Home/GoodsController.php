<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Yansongda\Pay\Pay;
use Endroid\QrCode\QrCode;

class GoodsController extends Controller
{
    // 加入购物车
    public function addCart(){
        $skuid = $_GET['skuid'];
        $count = $_GET['count'];
        $good = DB::table('goods')->select('goods.goods_name','goods.sm_logo','goods_sku.sku_name','goods_sku.price')
                            ->leftJoin('goods_sku','goods.id','goods_sku.goods_id')
                            ->where('goods_sku.id',$skuid)
                            ->first();
        $flow = time().rand(100,999);

        DB::table('order')->insert([
            'goods_name'=>$good->goods_name,
            'goods_logo'=>$good->sm_logo,
            'sku_name'=>$good->sku_name,
            'price'=>$good->price,
            'count'=>$count,
            'flow_number'=>$flow
        ]);
    }

    // 购物车
    public function cart(){

        return view('home.index.cart');
    }
    public function orders(){

        $orders = DB::table('order')->where('status','0')->orderBy('id','desc')->get();
        echo $orders;
    }

    // axios修改订单商品数量
    public function updateCount(){
        $id = $_GET['id'];
        $count = $_GET['count'];
        
        DB::table('order')->where('id',$id)->update([
            'count'=>$count
        ]);
    }

    // axios修改订单商品是否选中
    public function updateCheck(){
        $id = $_GET['id'];
        $checked = $_GET['checked'];
        if($checked == 'true'){
            DB::table('order')->where('id',$id)->update([
                'checked'=>1
            ]);
        }else {
            DB::table('order')->where('id',$id)->update([
                'checked'=>0
            ]);
        }
    }

    // 订单提交微信支付
    public function wxpay(){
        // dd(123);
        $config = [
            'app_id' => 'wx426b3015555a46be', // 公众号 APPID
            'mch_id' => '1900009851',
            'key' => '8934e7d15453e97507ef794cf7b0519d',
            'notify_url' => 'http://cea3e421.ngrok.io/wxpay/notify',
        ];

        $orders = DB::table('order')->where('checked','1')->get();
        // dd($orders);
        $totalPrice = 0;
        foreach($orders as $v){
            $totalPrice += $v->count * $v->price;
        }
        // dd($totalPrice);

        $sn = time().rand(100,999);

        $pay = Pay::wechat($config)->scan([
            'out_trade_no' => $sn,
            'total_fee' => $totalPrice * 100, // **单位：分**
            'body' => '订单总价格 ：'.($totalPrice * 100).'元',
            // 'openid' => 'onkVf1FjWS5SBIixxxxxxx',
        ]);
        
        $code = $pay->code_url;

        return view('home.index.wxpay',['code'=>$code,'sn'=>$sn,'totalPrice'=>$totalPrice]);
    }

    public function notify()
    {
        $config = [
            'app_id' => 'wx426b3015555a46be', // 公众号 APPID
            'mch_id' => '1900009851',
            'key' => '8934e7d15453e97507ef794cf7b0519d',
            'notify_url' => 'http://cea3e421.ngrok.io/wxpay/notify',
        ];
        $pay = Pay::wechat($config);
        try{
            $data = $pay->verify(); // 是的，验签就这么简单！

            // 判断是否支付成功
            if($data->result_code == 'SUCCESS' && $data->return_code == 'SUCCESS')
            {

                if($orderInfo && $orderInfo['status'] == 0){

                }
            }

        } catch (Exception $e) {

        }
        // 发送响应
        return $pay->success();
    }

    public function qrcode(){

        $code = $_GET['code'];

        $qrCode = new QrCode($code);
        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
    }
}
