<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;
use App\Model\CartModel;

class CartController extends Controller
{
    //
    public function cart(){
        // 接收数据
        $post_data = json_decode(file_get_contents("php://input"));
        // var_dump($post_data);die;
        $goods_id=$post_data->goods_id;
        $uid=$post_data->uid;
        $num=$post_data->num;
        $cart = CartModel::where(['uid'=>$uid,'goods_id'=>$goods_id])->first();
        if($cart){
            $data = [
                'num' =>$cart['num'] + $num
            ];
            $res = CartModel::where(['uid'=>$uid,'goods_id'=>$goods_id])->update($data);
        }else{
            $goods = GoodsModel::where('id',$goods_id)->first();
            $data = [
                'goods_id'  => $goods_id,
                'goods_name'  => $goods['name'],
                'goods_price'  => $goods['price'],
                'num'  => $num,
                'uid'  => $uid,
                'add_time'  => time()
            ];
            $res = CartModel::insert($data);
        }
        if($res){
            $response = [
                'error'  => 0,
                'msg'  => "ok"
            ];
        }else{
            $response = [
                'error'  => 50023,
                'msg'  => "添加购物车失败"
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
}
