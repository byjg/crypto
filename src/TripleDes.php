<?php

namespace ByJG\Crypto;


abstract class TripleDes extends BaseCrypto
{
    public function encrypt($plainText)
    {
        $this->cryptoMethod = "DES3";
        $this->cryptoOptions = OPENSSL_CIPHER_3DES;

        return parent::encrypt($plainText);
    }

    public function decrypt($encryptText) {

        $this->cryptoMethod = "DES3";
        $this->cryptoOptions = OPENSSL_CIPHER_3DES;

        return parent::decrypt($encryptText);
    }
}
