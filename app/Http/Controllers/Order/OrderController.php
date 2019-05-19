<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * 订单详情
     */
    public function info()
    {
        $oid = intval($_GET['oid']);
        $info = OrderModel::where(['oid'=>$oid])->first();
        echo '<pre>';print_r($info);echo '</pre>';
        return view('order.pay');
    }
    /**
     * 生成新订单
     */
    public function newOrder()
    {
        echo date('Y-m-d H:i:s');echo '</br>';
        $order_sn = '1809a_' .date('ymd') .'_'. mt_rand(1111,9999) .'_'. strtolower(Str::random(8));
        echo '<hr>';
        $data = [
            'order_sn'  => $order_sn,
            'uid'       => 0,
            'order_amount'  => mt_rand(1,100),
            'add_time'  => time(),
        ];
        $oid = OrderModel::insertGetId($data);
        echo 'oid: '.$oid;
        echo '<hr>';
        echo '<pre>';print_r($data);echo '</pre>';
    }
    public function order(){
        // 接收数据
        $post_data = json_decode(file_get_contents("php://input"));
        // var_dump($post_data);die;
        $uid=$post_data->uid;
        $goods_id=$post_data->goods_id;
        echo $goods_id;die;
        $order_sn = '1809a_' .date('ymd') .'_'. mt_rand(1111,9999) .'_'. strtolower(Str::random(8));
        $data = [
            'order_sn'  => $order_sn,
            'uid'       => $uid,
            'order_amount'  => 100,
            'add_time'  => time(),
        ];
        $oid = OrderModel::insertGetId($data);
        echo $oid;

        foreach($goods as $k=>$v){
            $detail = [
                'oid' => $oid,
                'goods_id' => $v['goods_id'],
                'goods_name' => $v['goods_name'],
                'goods_price' => $v['goods_price'],
                'uid' => Auth::id()
            ];
            OrderDetailModel::insertGetId($detail);
        }
        echo "生成订单成功";
    }
}
