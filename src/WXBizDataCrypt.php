<?php
namespace PhpRush\Wechat\Applet;

use PhpRush\Wechat\Applet\Exceptions\IllegalIvException;
use PhpRush\Wechat\Applet\Exceptions\IllegalAesKeException ;
use PhpRush\Wechat\Applet\Exceptions\IllegalBufferException;

class WXBizDataCrypt
{

    private $appid;

    private $sessionKey;

    /**
     * 构造函数
     *
     * @param $sessionKey 用户在小程序登录后获取的会话密钥            
     * @param $appid 小程序的appid            
     */
    function __construct($appid, $sessionKey)
    {
        $this->appid = $appid;
        $this->sessionKey = $sessionKey;
    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     *
     * @param $encryptedData 加密的用户数据            
     * @param $iv 与用户数据一同返回的初始向量            
     * @param $data 解密后的原文            
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData($encryptedData, $iv)
    {
        if (strlen($this->sessionKey) != 24) {
            throw new IllegalAesKeException("不合法的AesKey");
        }
        $aesKey = base64_decode($this->sessionKey);
        if (strlen($iv) != 24) {
            throw new IllegalIvException("不合法的Iv");
        }
        
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $pc = new Prpcrypt($aesKey);
        
        $result = $pc->decrypt($aesCipher, $aesIV);
        
        $data = json_decode($result, true);
        if ($data == NULL) {
            throw new IllegalBufferException("不合法的Buffer");
        }
        
        if (array_get($data, 'watermark.appid') != $this->appid) {
            throw new IllegalBufferException("不合法的Buffer");
        }
        
        return $data;
    }
}