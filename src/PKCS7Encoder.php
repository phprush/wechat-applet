<?php
namespace PhpRush\Wechat\Applet;

class PKCS7Encoder
{

    protected static $blockSize = 16;

    function encode($text)
    {
        $textLength = strlen($text);
        $amountToPad = self::$blockSize - ($textLength % self::$blockSize);
        if ($amountToPad == 0) {
            $amountToPad = self::$blockSize;
        }
        $pad_chr = chr($amountToPad);
        $tmp = "";
        for ($index = 0; $index < $amountToPad; $index ++) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }

    function decode($text)
    {
        $pad = ord(substr($text, - 1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }
}