<?php
return [
    'appid' => env('WECHAT_APPLET_APPID', ''),
    'secret' => env('WECHAT_APPLET_SECRET', ''),
    'code2session_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code"
];

