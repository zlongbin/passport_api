<?php
/**
 * 对称加密     加密
 */
function Sym_encrypt($data){
    // 双方约定好的参数
    $method = "AES-256-CBC";
    $key = "zxcvbnm";
    $options = OPENSSL_RAW_DATA;
    $iv = "zxcvbnm123456789";
    $enc_str = openssl_encrypt($data,$method,$key,$options,$iv);
    $b64 = base64_encode($enc_str);
    return $b64;
}
/**
 * 对称加密     解密
 */
function Sym_decrypt($b64){
    // 双方约定好的参数
    $method = "AES-256-CBC";
    $key = "zxcvbnm";
    $options = OPENSSL_RAW_DATA;
    $iv = "zxcvbnm123456789";

    $de_b64 = base64_decode($b64);
    $data = openssl_decrypt($de_b64,$method,$key,$options,$iv);
    return $data;
}

/**
 * 非对称加密   加密
 */
// 私钥加密
function Asym_private_encrypt($data,$keyfeil="private_key.pem"){
    $json_data = json_encode($data);
    $private_key = openssl_get_privatekey("file:///".storage_path('app/keys/'.$keyfeil));
    openssl_private_encrypt($json_data,$enc_json,$private_key);
    $b64 = base64_encode($enc_json);
    return $b64;
}
// 公钥加密
function Asym_public_encrypt($data,$keyfeil){
    $json_data = json_encode($data);
    $public_key = openssl_get_publickey("file:///".storage_path('app/keys/'.$keyfeil));
    openssl_public_encrypt($json_data,$enc_json,$public_key);
    $b64 = base64_encode($enc_json);
    return $b64;
}
/**
 * 非对称加密   解密
 */
// 私钥解密
function Asym_private_decrypt($b64,$keyfeil="private_key.pem"){
    $enc_json = base64_decode($b64);
    $private_key = openssl_get_privatekey("file:///".storage_path('app/keys/'.$keyfeil));
    openssl_private_decrypt($enc_json,$dec_json,$private_key);
    $data = json_decode($dec_json);
    return $data;
}
//公钥解密
function Asym_public_decrypt($b64,$keyfeil){
    $enc_json = base64_decode($b64);
    $public_key = openssl_get_publickey("file:///".storage_path('app/keys/'.$keyfeil));
    openssl_public_decrypt($enc_json,$dec_json,$public_key);
    $data = json_decode($dec_json);
    return $data;
}
/**
 * 生成签名
 */
function generate_sign($data,$keyfeil="private_key.pem"){
    // 获取私钥
    $private_key = openssl_get_privatekey("file:///".storage_path('app/keys/'.$keyfeil));
    // 生成签名
    openssl_sign($data,$signature,$private_key);
    // $signature为生成的签名   使用URL传输，进行urlcode处理
    $signature =  urlencode($signature);
    return $signature;
}
/**
 * 验证签名
 */
function verify_sign($data,$signature,$keyfeil){
    // 获取私钥
    $public_key = openssl_get_publickey("file:///".storage_path('app/keys/'.$keyfeil));
    // 验证签名     $signature为openssl_sign生成的签名
    $verify = openssl_verify($data,$signature,$public_key);
    // 如果签名正确返回 1, 签名错误返回 0, 内部发生错误则返回-1
    return $verify;
}
/**
 * CURL
 */
function curl($url,$data){
    // 转换为json字符串
    $json_data = json_encode($data);
    // curl请求     传输文件的格式为json
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);  //需要获取的URL地址
    curl_setopt($ch,CURLOPT_POST,1);    //发送post请求
    curl_setopt($ch,CURLOPT_HEADER,0);  //启用时会将头文件的信息作为数据流输出
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);   //禁止浏览器输出

    curl_setopt($ch,CURLOPT_POSTFIELDS,$json_data);
    curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);

    $info = curl_exec($ch);

    curl_close($ch);
    return $info;
}
/**
 * 获取token
 */
function getLoginToken($uid){
    // $key = "login_token:uid:".$uid;
    // $token = Redis::get($key);
    // if($token){
    //     return $token;
    // }else{
    //     $login_token = substr(sha1(time().$uid.Str::random(10)),5,16);
    //     Redis::set($key,$login_token);
    //     Redis::expire($key,604800);
    //     return $login_token;
    // }
    $login_token = substr(sha1(time().$uid.str_random(10)),5,16);
    return $login_token;
}
/**
 * 凯撒加密     加密
 */
function Caesar_encrypt($string,$n = 1){
    $count = strlen($string);
    $chr = '';
    for($i=0;$i<=$count-1;$i++){
        $string[$i];
        $ord = ord($string[$i]);
        $chr .= chr($ord + $n);
    }
    return $chr;
}
/**
 * 凯撒加密     解密
 */
function Caesar_decrypt($string,$n = 1){
    $count = strlen($string);
    $chr = '';
    for($i=0;$i<=$count-1;$i++){
        // echo $i;
        $string[$i];
        $ord = ord($string[$i]);
        $chr .= chr($ord - $n);
    }
    return $chr;
}
?>