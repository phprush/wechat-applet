<?php
namespace PhpRush\Wechat\Applet;

class PKCS7Encoder
{

    protected static $blockSize = 16;

    /**
     * 对需要加密的明文进行填充补位
     *
     * @param $text 需要进行填充补位操作的明文            
     * @return 补齐明文字符串
     */
    function encode($text)
    {
        $textLength = strlen($text);
        // 计算需要填充的位数
        $amountToPad = self::$blockSize - ($textLength % self::$blockSize);
        if ($amountToPad == 0) {
            $amountToPad = self::$blockSize;
        }
        // 获得补位所用的字符
        $pad_chr = chr($amountToPad);
        $tmp = "";
        for ($index = 0; $index < $amountToPad; $index ++) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }

    /**
     * 对解密后的明文进行补位删除
     *
     * @param $text 解密后的明文            
     * @return 删除填充补位后的明文
     */
    function decode($text)
    {
        $pad = ord(substr($text, - 1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }
}