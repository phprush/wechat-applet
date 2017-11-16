<?php
namespace PhpRush\Wechat\Applet\Facades;

use Illuminate\Support\Facades\Facade;

class WechatApplet extends Facade
{

    /**
     * 获取组件的注册名称。
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'WechatApplet';
    }
}