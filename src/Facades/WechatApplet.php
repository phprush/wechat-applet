<?php
namespace PhpRush\Wechat\Applet\Facades;

use Illuminate\Support\Facades\Facade;

class WechatApplet extends Facade
{

    /**
     * ��ȡ�����ע�����ơ�
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'WechatApplet';
    }
}