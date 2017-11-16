# wechat-applet

### 使用方式
```
/**
 * Laravel 5 微信小程序插件
 * @see https://mp.weixin.qq.com/debug/wxadoc/dev/api/
 * @exception Exception
 * @return array
 */
 
$code = 'xxxxxxxx';
        
try {
    $loginInfo = WechatApplet::getLoginInfo($code);
    dump($loginInfo);
} catch ( Exception $e) {
    dump($e);
}
```

### 安装方式
```
composer require phprush/wechat-applet

php artisan vendor:publish --provider="PhpRush\Wechat\Applet\WechatAppletServiceProvider"

###### https://d.laravel-china.org/docs/5.5/providers
array_merge(config('app.providers'), [
  PhpRush\Wechat\Applet\WechatAppletServiceProvider::class
]);

###### https://d.laravel-china.org/docs/5.5/facades
array_merge(config('app.aliases'), [
  'WechatApplet' => PhpRush\Wechat\Applet\Facades\WechatApplet::class
]);
```

### 在config/wechat/applet.php 中使用 env('WECHAT_APPLET_APPID')/env('WECHAT_APPLET_SECRET')
```
vim .env
  WECHAT_APPLET_APPID=xxxxxxxx
  WECHAT_APPLET_SECRET=xxxxxxxx
```
