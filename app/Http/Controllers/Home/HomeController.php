<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AjaxUserModel;

class HomeController extends Controller
{
    public function center(){
        // 接收数据
        $post_data = json_decode(file_get_contents("php://input"));
        // var_dump($post_data);die;
        $token=$post_data->token;
        $uid=$post_data->uid;
        $key="login_token:uid".$uid;
        $loca_token = Redis::get($key);
        if($token = $loca_token){
            $user_info = AjaxUserModel::where(['id'=>$uid])->first();
            $response = [
                'error' => 0,
                'msg'   =>  'ok',
                'account'  => $user_info['account'],
                'email'  => $user_info['email']
            ];
        }else{
            $response = [
                'error' => 50020,
                'msg'   =>  'token值过期，请重新登录',
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
}
