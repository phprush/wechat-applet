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
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            mcrypt_generic_init($module, $this->key, $aesIV);
            
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