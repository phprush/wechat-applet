<?php
namespace PhpRush\Wechat\Applet;

use Requests;
use Exception;

class WechatApplet
{

    private $appId;

    private $secret;

    private $code2session_url;

    private $openId;

    private $sessionKey;

    private $authInfo;

    function __construct($wxConfig)
    {
        $this->appId = isset($wxConfig["appid"]) ? $wxConfig["appid"] : "";
        $this->secret = isset($wxConfig["secret"]) ? $wxConfig["secret"] : "";
        $this->code2session_url = isset($wxConfig["code2session_url"]) ? $wxConfig["code2session_url"] : "";
    }

    public function getLoginInfo($code)
    {
        $this->authCodeAndCode2session($code);
        return $this->authInfo;
    }

    public function getUserInfo($encryptedData, $iv)
    {
        $pc = new WXBizDataCrypt($this->appId, $this->sessionKey);
        $decodeData = "";
        $errCode = $pc->decryptData($encryptedData, $iv, $decodeData);
        if ($errCode != 0) {
            throw new Exception('weixin_decode_fail');
        }
        return $decodeData;
    }

    private function authCodeAndCode2session($code)
    {
        $code2session_url = sprintf($this->code2session_url, $this->appId, $this->secret, $code);
        
        $response = Requests::get($code2session_url);
        
        $this->authInfo = json_decode($response->body, true);
        if (! isset($this->authInfo['openid'])) {
            throw new Exception('weixin_session_expired');
        }
        
        $this->openId = isset($this->authInfo['openid']) ? $this->authInfo['openid'] : "";
        $this->sessionKey = isset($this->authInfo['session_key']) ? $this->authInfo['session_key'] : "";
    }
}