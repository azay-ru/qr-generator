<?php

namespace Azay\Qr;

class QRAlphaNum extends QRData
{

    function __construct($data)
    {
        parent::__construct(QRCode::QR_MODE_ALPHA_NUM, $data);
    }

    function write(&$buffer)
    {

        $i = 0;
        $c = $this->getData();

        while ($i + 1 < strlen($c)) {
            $buffer->put(QRAlphaNum::getCode(ord($c[$i])) * 45
                + QRAlphaNum::getCode(ord($c[$i + 1])), 11);
            $i += 2;
        }

        if ($i < strlen($c)) {
            $buffer->put(QRAlphaNum::getCode(ord($c[$i])), 6);
        }
    }

    static function getCode($c)
    {

        if (QRUtil::toCharCode('0') <= $c
            && $c <= QRUtil::toCharCode('9')) {
            return $c - QRUtil::toCharCode('0');
        } else if (QRUtil::toCharCode('A') <= $c
            && $c <= QRUtil::toCharCode('Z')) {
            return $c - QRUtil::toCharCode('A') + 10;
        } else {
            switch ($c) {
                case QRUtil::toCharCode(' ') :
                    return 36;
                case QRUtil::toCharCode('$') :
                    return 37;
                case QRUtil::toCharCode('%') :
                    return 38;
                case QRUtil::toCharCode('*') :
                    return 39;
                case QRUtil::toCharCode('+') :
                    return 40;
                case QRUtil::toCharCode('-') :
                    return 41;
                case QRUtil::toCharCode('.') :
                    return 42;
                case QRUtil::toCharCode('/') :
                    return 43;
                case QRUtil::toCharCode(':') :
                    return 44;
                default :
                    trigger_error("illegal char : $c", E_USER_ERROR);
            }
        }

    }
}