<?php

namespace Azay\Qr;

abstract class QRData
{

    var $mode;

    var $data;

    function __construct($mode, $data)
    {
        $this->mode = $mode;
        $this->data = $data;
    }

    function getMode()
    {
        return $this->mode;
    }

    function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    function getLength()
    {
        return strlen($this->getData());
    }

    /**
     * @param QRBitBuffer $buffer
     */
    abstract function write(&$buffer);

    function getLengthInBits($type)
    {

        if (1 <= $type && $type < 10) {

            // 1 - 9

            switch ($this->mode) {
                case QRCode::QR_MODE_NUMBER     :
                    return 10;
                case QRCode::QR_MODE_ALPHA_NUM     :
                    return 9;
                case QRCode::QR_MODE_8BIT_BYTE    :
                    return 8;
                case QRCode::QR_MODE_KANJI      :
                    return 8;
                default :
                    trigger_error("mode:$this->mode", E_USER_ERROR);
            }

        } else if ($type < 27) {

            // 10 - 26

            switch ($this->mode) {
                case QRCode::QR_MODE_NUMBER     :
                    return 12;
                case QRCode::QR_MODE_ALPHA_NUM     :
                    return 11;
                case QRCode::QR_MODE_8BIT_BYTE    :
                    return 16;
                case QRCode::QR_MODE_KANJI      :
                    return 10;
                default :
                    trigger_error("mode:$this->mode", E_USER_ERROR);
            }

        } else if ($type < 41) {

            // 27 - 40

            switch ($this->mode) {
                case QRCode::QR_MODE_NUMBER     :
                    return 14;
                case QRCode::QR_MODE_ALPHA_NUM    :
                    return 13;
                case QRCode::QR_MODE_8BIT_BYTE    :
                    return 16;
                case QRCode::QR_MODE_KANJI      :
                    return 12;
                default :
                    trigger_error("mode:$this->mode", E_USER_ERROR);
            }

        } else {
            trigger_error("mode:$this->mode", E_USER_ERROR);
        }
    }

}