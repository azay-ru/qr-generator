<?php

namespace Azay\Qr;

class QR8BitByte extends QRData
{
    function __construct($data)
    {
        parent::__construct(QRCode::QR_MODE_8BIT_BYTE, $data);
    }

    function write(&$buffer)
    {

        $data = $this->getData();
        for ($i = 0; $i < strlen($data); $i++) {
            $buffer->put(ord($data[$i]), 8);
        }
    }

}