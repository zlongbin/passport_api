<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use App\Model\AjaxUserModel;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function passportReg(){
        // 接收数据
        $post_data = json_decode(file_get_contents("php://input"));
        // var_dump($post_data);die;
        $email=$post_data->email;
        $user_Info = AjaxUserModel::where(['email'=>$email])->first();
        if($user_Info){
            $response = [
                'error' => 50011,
                'msg'   =>  '该邮箱已被注册'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        $data = [
            'account'  =>  $account,
            'password'  =>  $password,
            'email'     =>  $email,
            'add_time'  =>  time()
        ];
        $id = AjaxUserModel::insertGetId($data);
        if($id){
            $response=[
                'error' => 0,
                'msg'   => 'ok'
            ];
        }else{
            $response=[
                'error' => 50013,
                'msg'   => '注册失败'
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
    public function passportLogin(){
        $post_data = json_decode(file_get_contents("php://input"));

        $email = $post_data->email;
        $password =  $post_data->password;
        $user_Info = AjaxUserModel::where(['email'=>$email])->first();
        // var_dump($password);
        if($user_Info){
            if($password==$user_Info['password']){
                $key="login_token:uid".$user_Info['id'];
                $token = getLoginToken($user_Info['id']);
                // Cache::put($key,$token,604800);
                // echo Cache::get($key);echo "<hr>";
                Redis::set($key,$token);
                Redis::get($key);
                $response = [
                    'error' => 0,
                    'msg'   =>  'ok',
                    'uid'   =>  $user_Info['id'],
                    'token' =>  $token
                ];
            }else{
                $response = [
                    'error' => 50010,
                    'msg'   =>  '密码错误',
                ];
            }
        }else{
            $response = [
                'error' => 50014,
                'msg'   =>  '该邮箱还未注册',
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
}
