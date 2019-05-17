<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    /**
     * 商品
     */
    public function goods(){
        $goods = GoodsModel::get()->toArray();
        // echo "<pre>";print_r($goods);echo "</pre>";
        die(json_encode($goods,JSON_UNESCAPED_UNICODE));
    }
    /**
     * 商品详情
     */
    public function goodsDetail(){
        // 接收数据
        $post_data = json_decode(file_get_contents("php://input"));
        // var_dump($post_data);die;
        $goods_id=$post_data->goods_id;
        $goods = GoodsModel::where('id',$goods_id)->first();
        if($goods){
            $response = [
                'error' => 0,
                'msg'   => 'ok',
                'data'  =>[
                    'id'    => $goods['id'],
                    'name'  => $goods['name'],
                    'price'  => $goods['price'],
                    'img'  => $goods['img'],
                    'store'  => $goods['store']
                ]
            ];
        }else{
            $response = [
                'error'  => 50022,
                'msg'  => "此商品已下架"
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
}
