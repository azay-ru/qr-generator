<?php

namespace Azay\Qr;

class QRNumber extends QRData
{

    function __construct($data)
    {
        parent::__construct(QRCode::QR_MODE_NUMBER, $data);
    }

    function write(&$buffer)
    {

        $data = $this->getData();

        $i = 0;

        while ($i + 2 < strlen($data)) {
            $num = QRNumber::parseInt(substr($data, $i, 3));
            $buffer->put($num, 10);
            $i += 3;
        }

        if ($i < strlen($data)) {

            if (strlen($data) - $i == 1) {
                $num = QRNumber::parseInt(substr($data, $i, $i + 1));
                $buffer->put($num, 4);
            } else if (strlen($data) - $i == 2) {
                $num = QRNumber::parseInt(substr($data, $i, $i + 2));
                $buffer->put($num, 7);
            }
        }
    }

    static function parseInt($s)
    {

        $num = 0;
        for ($i = 0; $i < strlen($s); $i++) {
            $num = $num * 10 + QRNumber::parseIntAt(ord($s[$i]));
        }
        return $num;
    }

    static function parseIntAt($c)
    {

        if (QRUtil::toCharCode('0') <= $c && $c <= QRUtil::toCharCode('9')) {
            return $c - QRUtil::toCharCode('0');
        }

        trigger_error("illegal char : $c", E_USER_ERROR);
    }
}