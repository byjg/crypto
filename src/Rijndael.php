<?php

namespace ByJG\Crypto;


abstract class Rijndael implements CryptoInterface
{

    abstract public function getKeys();

    public function getKeyPart($keyNumber, $part)
    {
        $keyPart = $this->getKeys();

        if ($part == 1) {
            return substr(hex2bin($keyPart[$keyNumber]), 0, 16);
        } else {
            return substr(hex2bin($keyPart[$keyNumber]), -16);
        }
    }

    public function encrypt($sValue)
    {
        $maxPossibleKeys = count($this->getKeys()) - 1;

        $bitA = rand(0, $maxPossibleKeys);
        $bitB = rand(0, $maxPossibleKeys);

        $sSecretKey = $this->getKeyPart($bitA, 1) . $this->getKeyPart($bitB, 2);

        $crypto = mcrypt_encrypt(
            MCRYPT_RIJNDAEL_256, $sSecretKey, $sValue, MCRYPT_MODE_ECB, mcrypt_create_iv(
                mcrypt_get_iv_size(
                    MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB
                ), MCRYPT_RAND)
        );

        return rtrim(
            base64_encode(bin2hex(chr($bitA)) . bin2hex(chr($bitB)) . $crypto), "\0"
        );
    }

    public function decrypt($sValue)
    {
        $key = base64_decode($sValue);

        $bitA = ord(hex2bin(substr($key, 0, 2)));
        $bitB = ord(hex2bin(substr($key, 2, 2)));

        $sSecretKey = $this->getKeyPart($bitA, 1) . $this->getKeyPart($bitB, 2);

        return rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256, $sSecretKey, substr($key, 4), MCRYPT_MODE_ECB, mcrypt_create_iv(
                    mcrypt_get_iv_size(
                        MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB
                    ), MCRYPT_RAND
                )
            ), "\0"
        );
    }
}