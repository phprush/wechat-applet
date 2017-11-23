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

    public function decrypt($aesCipher, $aesIV)
    {
        try {
            $decrypted = openssl_decrypt($aesCipher, 'AES-128-CBC', $this->key, OPENSSL_ZERO_PADDING, $aesIV);
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