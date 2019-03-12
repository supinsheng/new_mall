<?php

require('./vendor/autoload.php');

use Qiniu\Storage\UploadManager;
use Qiniu\Auth;

$pdo = new \PDO('mysql:host=127.0.0.1;dbname=new_mall', 'root','123');

$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'localhost',
    'port'   => 6379,
]);

// 设置 socket 永不超时
ini_set('default_socket_timeout', -1);

// 上传七牛云
$accessKey = 'aMC80PYsa8nH81Bq0j28SV9b6DMNe_e1-Z0poome';
$secretKey = 'aWAw3JE8PUGQx6UL9LZvxeddBtlmU0WAO8A3Xd94';
$domain = 'http://pity1gof8.bkt.clouddn.com';

// 配置参数
$bucketName = 'vue-shop1';   // 创建的 bucket(新建的存储空间的名字)

$upManager = new UploadManager();

// 登录获取令牌
$expire = 86400 * 3650; // 令牌过期时间10年
$auth = new Auth($accessKey, $secretKey);
$token = $auth->uploadToken($bucketName, null, $expire);

while(true){
    $rawData = $client->brpop('new_mall:qiniu',0);
    // 处理数据
    $data = unserialize($rawData[1]);
    // 获取文件名
    $name = ltrim(strrchr($data['logo'],'/'),'/');
    // 上传的文件
    $file = './public'.$data['logo'];
    list($ret, $error) = $upManager->putFile($token, $name, $file);

    if($error !== null){
        // 如果失败，重新将数据放回队列
        $client->lpush('new_mall:qiniu',$rawData[1]);
    }else {
        // 更新数据库
        $new = $domain.'/'.$ret['key'];
        
        $sql = "UPDATE ".$data['table']." SET ".$data['column']."='$new' WHERE id=".$data['id'];
        $pdo->exec($sql);
        // 删除本地文件
        @unlink($file);
        echo 'ok';
    }
}