<?php

echo "class MyClass extends \\ByJG\\Crypto\\Rijndael\n";
echo "{\n";
echo "    public function getKeys()\n";
echo "    {\n";
echo "        return [ \n";
for($i=0;$i<32;$i++) {
    echo "            '" . bin2hex(openssl_random_pseudo_bytes(32)) . "',\n";
}
echo "        ];\n";
echo "    }\n";
echo "}\n";
