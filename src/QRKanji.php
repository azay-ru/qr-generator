<?php

namespace Azay\Qr;

class QRKanji extends QRData
{

    function __construct($data)
    {
        parent::__construct(QRCode::QR_MODE_KANJI, $data);
    }

    function write(&$buffer)
    {

        $data = $this->getData();

        $i = 0;

        while ($i + 1 < strlen($data)) {

            $c = ((0xff & ord($data[$i])) << 8) | (0xff & ord($data[$i + 1]));

            if (0x8140 <= $c && $c <= 0x9FFC) {
                $c -= 0x8140;
            } else if (0xE040 <= $c && $c <= 0xEBBF) {
                $c -= 0xC140;
            } else {
                trigger_error("illegal char at " . ($i + 1) . "/$c", E_USER_ERROR);
            }

            $c = (($c >> 8) & 0xff) * 0xC0 + ($c & 0xff);

            $buffer->put($c, 13);

            $i += 2;
        }

        if ($i < strlen($data)) {
            trigger_error("illegal char at " . ($i + 1), E_USER_ERROR);
        }
    }

    function getLength()
    {
        return floor(strlen($this->getData()) / 2);
    }
}