<?php
/*Rev:26.09.18r0*/

class geoip
{
    private static $DATA_SECTION_SEPARATOR_SIZE = 16;
    private static $METADATA_START_MARKER = '???MaxMind.com';
    private static $METADATA_START_MARKER_LENGTH = 14;
    private static $METADATA_MAX_SIZE = 131072;
    private $decoder;
    private $fileHandle;
    private $fileSize;
    private $ipV4Start;
    private $metadata;
    public function __construct($fcc5f944181b5dfc52629a41a9236ae1)
    {
        if (func_num_args() !== 1) {
            throw new \ae5EaBb8757C4178c9cFcD053eDB2D63('The constructor takes exactly one argument.');
        }
        if (!is_readable($fcc5f944181b5dfc52629a41a9236ae1)) {
            throw new \aE5eAbb8757c4178C9cfcd053EDb2D63("The file \"{$fcc5f944181b5dfc52629a41a9236ae1}\" does not exist or is not readable.");
        }
        $this->fileHandle = @fopen($fcc5f944181b5dfc52629a41a9236ae1, 'rb');
        if ($this->fileHandle === false) {
            throw new \AE5eABB8757C4178C9cFCD053EDb2D63("Error opening \"{$fcc5f944181b5dfc52629a41a9236ae1}\".");
        }
        $this->fileSize = @filesize($fcc5f944181b5dfc52629a41a9236ae1);
        if ($this->fileSize === false) {
            throw new \B68B5Fc2ED0F8828d9E33d8AC600B9D7("Error determining the size of \"{$fcc5f944181b5dfc52629a41a9236ae1}\".");
        }
        $start = $this->A7C32B46AF6F256bB22e0a3982D786CB($fcc5f944181b5dfc52629a41a9236ae1);
        $ecbfff81299dedd5de46f4305f849144 = new Dd866CD266d22904DB08CeDe9c891eEb($this->fileHandle, $start);
        list($A06049ff11525b574ab80633c9756336) = $ecbfff81299dedd5de46f4305f849144->A13C48203F7686Cc9D7129Db62Ce01bD($start);
        $this->metadata = new d3306B41F5D6529552c29749c22a8518($A06049ff11525b574ab80633c9756336);
        $this->decoder = new Dd866CD266D22904dB08cEDe9c891Eeb($this->fileHandle, $this->metadata->searchTreeSize + self::$DATA_SECTION_SEPARATOR_SIZE);
    }
    public function C6A76952B4Cef18f3C98C0e6A9dD1274($c74ae485951336031407d08ac68be11b)
    {
        if (func_num_args() !== 1) {
            throw new \Ae5eAbb8757c4178C9cFCd053eDB2d63('Method takes exactly one argument.');
        }
        if (!is_resource($this->fileHandle)) {
            throw new \F09F1544c2E3158905ec968A08EC0995('Attempt to read from a closed MaxMind DB.');
        }
        if (!filter_var($c74ae485951336031407d08ac68be11b, FILTER_VALIDATE_IP)) {
            throw new \Ae5eAbB8757C4178c9CFcd053edB2d63("The value \"{$c74ae485951336031407d08ac68be11b}\" is not a valid IP address.");
        }
        if ($this->metadata->ipVersion === 4 && strrpos($c74ae485951336031407d08ac68be11b, ':')) {
            throw new \ae5EaBB8757C4178c9CfCd053Edb2D63("Error looking up {$c74ae485951336031407d08ac68be11b}. You attempted to look up an" . ' IPv6 address in an IPv4-only database.');
        }
        $ecbe9cf84c74cb6bd2bc530654115271 = $this->fb57309c1eAF4A3c84605fce746c871b($c74ae485951336031407d08ac68be11b);
        if ($ecbe9cf84c74cb6bd2bc530654115271 === 0) {
            return null;
        }
        return $this->ED2Ed02968e0ac84cD8A8C8Fa75E3c1b($ecbe9cf84c74cb6bd2bc530654115271);
    }
    private function fb57309c1EAF4A3C84605fCE746C871B($c74ae485951336031407d08ac68be11b)
    {
        $Ee409cb1f2af7c6c57fafe34153897e5 = array_merge(unpack('C*', inet_pton($c74ae485951336031407d08ac68be11b)));
        $e8351c0a0bb14dbcb1ae4b47d16ad8e0 = count($Ee409cb1f2af7c6c57fafe34153897e5) * 8;
        $E21561cba90465c4a869c01eb89269bf = $this->E1644cfFB8f7835A8173DF9d028211f0($e8351c0a0bb14dbcb1ae4b47d16ad8e0);
        $index = 0;
        //E398a6489e00d6e1e9e0dcfc0c3eff17:
        while ($index < $e8351c0a0bb14dbcb1ae4b47d16ad8e0) {
            if ($E21561cba90465c4a869c01eb89269bf >= $this->metadata->nodeCount) {
                break;
            }
            $Ee3f052e30ec491b95ae9b13cbc506f4 = 255 & $Ee409cb1f2af7c6c57fafe34153897e5[$index >> 3];
            $C8fc07afc7ecf3e8b7eaedada7742f62 = 1 & $Ee3f052e30ec491b95ae9b13cbc506f4 >> 7 - $index % 8;
            $E21561cba90465c4a869c01eb89269bf = $this->d5c6C48459bbFBd01086116BcB860620($E21561cba90465c4a869c01eb89269bf, $C8fc07afc7ecf3e8b7eaedada7742f62);
            $index++;
        }
        //ad933c7c8e2ab343f44ce73a84a2fb0e:
        if (($E21561cba90465c4a869c01eb89269bf === $this->metadata->nodeCount)) {
                //e6b253347f015d8bd4cf91a853e8381a:
                return 0;
                //goto F2389e64fb1dc9a7f848c0856abbdf28; 
        }
        else if ($E21561cba90465c4a869c01eb89269bf > $this->metadata->nodeCount) {
            return $E21561cba90465c4a869c01eb89269bf;
        } 
        throw new e5Fea4Bb1753b166E279E9172aD7B28d('Something bad happened');
    }
    private function E1644Cffb8f7835a8173Df9d028211F0($length)
    {
        if ($this->metadata->ipVersion === 6 && $length === 32) {
            return $this->AA29eC1cCc612005AeB68f6Cc11bF9F6();
        }
        return 0;
    }
    private function aa29Ec1cCc612005AEb68f6Cc11bf9f6()
    {
        if ($this->metadata->ipVersion === 4) {
            return 0;
        }
        if ($this->ipV4Start) {
            return $this->ipV4Start;
        }
        $E21561cba90465c4a869c01eb89269bf = 0;
        $index = 0;
        //d0168f94f95e0ace10a7104528667d0e:
        while ($index < 96 && $E21561cba90465c4a869c01eb89269bf < $this->metadata->nodeCount) {
            $E21561cba90465c4a869c01eb89269bf = $this->D5c6c48459BbfbD01086116BCb860620($E21561cba90465c4a869c01eb89269bf, 0);
            $index++;
        }
        //c02ee6d5b6c4f5b46486405c7330e441:
        $this->ipV4Start = $E21561cba90465c4a869c01eb89269bf;
        return $E21561cba90465c4a869c01eb89269bf;
    }
    private function D5C6c48459bBfbD01086116BCB860620($c2d96fe54387f063a208006b486a7d91, $D4305bd800f15145a64f9ab75d98c121)
    {
        $ebc2c8150b129fd1645db3e81b1a9eb5 = $c2d96fe54387f063a208006b486a7d91 * $this->metadata->nodeByteSize;
        switch ($this->metadata->recordSize) {
            case 24:
                $e13ac89e162bcc9913e553b949f755b6 = c71f9a0Aa9539e5Bbb23F465B5b8A992::ad87a931cdE9286D705B4954d6B159d3($this->fileHandle, $ebc2c8150b129fd1645db3e81b1a9eb5 + $D4305bd800f15145a64f9ab75d98c121 * 3, 3);
                list(, $E21561cba90465c4a869c01eb89269bf) = unpack('N', ' ' . $e13ac89e162bcc9913e553b949f755b6);
                return $E21561cba90465c4a869c01eb89269bf;
            case 28:
                $e2ef3a957162e942cac3ec5ceebdcdea = C71F9A0aa9539e5BbB23f465B5B8a992::Ad87a931CDe9286D705B4954d6b159d3($this->fileHandle, $ebc2c8150b129fd1645db3e81b1a9eb5 + 3, 1);
                list(, $Fc8639fe976d9e5cccc0279654b9e2ca) = unpack('C', $e2ef3a957162e942cac3ec5ceebdcdea);
                if ($D4305bd800f15145a64f9ab75d98c121 === 0) {
                    $Fc8639fe976d9e5cccc0279654b9e2ca = (240 & $Fc8639fe976d9e5cccc0279654b9e2ca) >> 4;
                } else {
                    $Fc8639fe976d9e5cccc0279654b9e2ca = 15 & $Fc8639fe976d9e5cccc0279654b9e2ca;
                }
                $e13ac89e162bcc9913e553b949f755b6 = c71f9a0AA9539e5BbB23f465b5B8a992::aD87A931CDE9286d705B4954D6b159d3($this->fileHandle, $ebc2c8150b129fd1645db3e81b1a9eb5 + $D4305bd800f15145a64f9ab75d98c121 * 4, 3);
                list(, $E21561cba90465c4a869c01eb89269bf) = unpack('N', chr($Fc8639fe976d9e5cccc0279654b9e2ca) . $e13ac89e162bcc9913e553b949f755b6);
                return $E21561cba90465c4a869c01eb89269bf;
            case 32:
                $e13ac89e162bcc9913e553b949f755b6 = c71f9a0Aa9539e5bbB23f465b5B8A992::aD87A931CDe9286d705B4954d6b159d3($this->fileHandle, $ebc2c8150b129fd1645db3e81b1a9eb5 + $D4305bd800f15145a64f9ab75d98c121 * 4, 4);
                list(, $E21561cba90465c4a869c01eb89269bf) = unpack('N', $e13ac89e162bcc9913e553b949f755b6);
                return $E21561cba90465c4a869c01eb89269bf;
            default:
                throw new e5fEA4BB1753B166e279E9172aD7B28d('Unknown record size: ' . $this->metadata->recordSize);
        }
    }
    private function ed2ED02968E0ac84Cd8A8c8Fa75e3c1B($ecbe9cf84c74cb6bd2bc530654115271)
    {
        $A623e87d85862face6475925165728ef = $ecbe9cf84c74cb6bd2bc530654115271 - $this->metadata->nodeCount + $this->metadata->searchTreeSize;
        if ($A623e87d85862face6475925165728ef > $this->fileSize) {
            throw new E5fEA4bB1753B166e279E9172aD7B28d('The MaxMind DB file\'s search tree is corrupt');
        }
        list($data) = $this->decoder->A13C48203F7686Cc9D7129Db62cE01bd($A623e87d85862face6475925165728ef);
        return $data;
    }
    private function a7c32B46aF6F256bb22e0A3982D786Cb($dae587fac852b56aefd2f953ed975545)
    {
        $fb1d4f6290dabf126bb2eb152b0eb565 = $this->fileHandle;
        $B07415feccc81fe5e7c5b2ffbd10f8b7 = fstat($fb1d4f6290dabf126bb2eb152b0eb565);
        $F5bcec0ef52d6f1ba3acd0ff7bc3d62a = $B07415feccc81fe5e7c5b2ffbd10f8b7['size'];
        $f72e31b73721572bd3e8244221755f8b = self::$METADATA_START_MARKER;
        $Dadcbaa6b04bbafcd2f96dc20782b59c = self::$METADATA_START_MARKER_LENGTH;
        $f63837d29d6878f4161ef8e9356da2dd = min(self::$METADATA_MAX_SIZE, $F5bcec0ef52d6f1ba3acd0ff7bc3d62a) - $Dadcbaa6b04bbafcd2f96dc20782b59c;
        $index = 0;
        //A51a3b27e65c4ab311de71ccda9e3873:
        while ($index <= $f63837d29d6878f4161ef8e9356da2dd) {
            $C9c5f05a2837ab86483ff2386b405be3 = 0;
            //A3bca08b3db896b44a2d7d1231daf246:
            while ($C9c5f05a2837ab86483ff2386b405be3 < $Dadcbaa6b04bbafcd2f96dc20782b59c) {
                fseek($fb1d4f6290dabf126bb2eb152b0eb565, $F5bcec0ef52d6f1ba3acd0ff7bc3d62a - $index - $C9c5f05a2837ab86483ff2386b405be3 - 1);
                $A742e5ef8513dc737be8897f56448090 = fgetc($fb1d4f6290dabf126bb2eb152b0eb565);
                if ($A742e5ef8513dc737be8897f56448090 !== $f72e31b73721572bd3e8244221755f8b[$Dadcbaa6b04bbafcd2f96dc20782b59c - $C9c5f05a2837ab86483ff2386b405be3 - 1]) {
                    break;
                }
                $C9c5f05a2837ab86483ff2386b405be3++;
            }
            //d52a92c2e63cc46f51c7399517a6e363:
            return $F5bcec0ef52d6f1ba3acd0ff7bc3d62a - $index;
            //d3bc476031956271c25c45d992cb2243:
            $index++;
        }
        //F8960d545a5353d79e4d6f3605042c4a:
        throw new E5Fea4Bb1753B166E279E9172AD7B28D("Error opening database file ({$dae587fac852b56aefd2f953ed975545}). " . 'Is this a valid MaxMind DB file?');
    }
    public function F2DA8F271085E2A519f6b5753eeD5024()
    {
        if (func_num_args()) {
            throw new \ae5eaBB8757C4178c9cFcd053edB2d63('Method takes no arguments.');
        }
        if (!is_resource($this->fileHandle)) {
            throw new \f09F1544c2E3158905eC968a08Ec0995('Attempt to read from a closed MaxMind DB.');
        }
        return $this->metadata;
    }
    public function close()
    {
        if (!is_resource($this->fileHandle)) {
            throw new \f09f1544c2e3158905EC968A08ec0995('Attempt to close a closed MaxMind DB.');
        }
        fclose($this->fileHandle);
    }
}
