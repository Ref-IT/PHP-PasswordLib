<?php

class Unit_Cipher_Block_Implementation_TripleDESTest extends PHPUnit_Framework_TestCase {

    /**
     * @return array The test vectors
     */
    public static function provideTestEncryptVectors() {
        $ret = array(
            array('800000000000000000000000000000000000000000000000', '0000000000000000', '95A8D72813DAA94D'),
            array('80000000000000000000000000000000', '0000000000000000', 'FAFD5084374FCE34'),
        );
        return $ret;
    }
    
    /**
     * @dataProvider provideTestEncryptVectors
     */
    public function testEncrypt($key, $data, $expected) {
        $cipher = new \CryptLib\Cipher\Block\Implementation\TripleDES('tripledes');
        $enc = $cipher->encryptBlock(pack('H*', $data), pack('H*', $key));
        $this->assertEquals($expected, strtoupper(bin2hex($enc)));
    }
    
    /**
     * @dataProvider provideTestEncryptVectors
     */
    public function testDecrypt($key, $expected, $data) {
        $cipher = new \CryptLib\Cipher\Block\Implementation\TripleDES('tripledes');
        $enc = $cipher->decryptBlock(pack('H*', $data), pack('H*', $key));
        $this->assertEquals($expected, strtoupper(bin2hex($enc)));
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testDecryptFailure() {
        $cipher = new \CryptLib\Cipher\Block\Implementation\TripleDES('tripledes');
        $cipher->decryptBlock(str_repeat(chr(0), 8), str_repeat(chr(0), 8));
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testEncryptFailure() {
        $cipher = new \CryptLib\Cipher\Block\Implementation\TripleDES('tripledes');
        $cipher->encryptBlock(str_repeat(chr(0), 8), str_repeat(chr(0), 8));
    }
    
    public function testBlockSize() {
        $cipher = new \CryptLib\Cipher\Block\Implementation\TripleDES('tripledes');
        $this->assertEquals(8, $cipher->getBlockSize('foo'));
    }
    
    public function testGetCipher() {
        $cipher = new \CryptLib\Cipher\Block\Implementation\TripleDES('tripledes');
        $this->assertEquals('tripledes', $cipher->getCipher());
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructFailure() {
        $cipher = new \CryptLib\Cipher\Block\Implementation\TripleDES('des');
    }

}
