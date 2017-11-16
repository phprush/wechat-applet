<?php
namespace PhpRush\Wechat\Applet;

use Exception;
use PhpRush\Wechat\Applet\Exceptions\IllegalBufferException;

class Prpcrypt
{

    protected $key;

    public function __construct($k)
    {
        $this->key = $k;
    }

    /**
     * 对密文进行解密
     *
     * @param $aesCipher 需要解密的密文            
     * @param $aesIV 解密的初始向量            
     * @return 解密得到的明文
     */
    public function decrypt($aesCipher, $aesIV)
    {
        try {
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            mcrypt_generic_init($module, $this->key, $aesIV);
            // 解密
            $decrypted = mdecrypt_generic($module, $aesCipher);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (Exception $e) {
            throw new IllegalBufferException("不合法的Buffer");
        }
        
        $result = '';
        try {
            $pkc_encoder = new PKCS7Encoder();
            $result = $pkc_encoder->decode($decrypted);
        } catch (Exception $e) {
            throw new IllegalBufferException("不合法的Buffer");
        }
        
        return $result;
    }
}