<?php
use PHPUnit\Framework\TestCase;

class CSRFTest extends TestCase
{
    private $csrf;
    
    protected function setUp(): void
    {
        $this->csrf = new CSRF();
    }
    
    public function testGenerateToken()
    {
        $token = $this->csrf->generateToken();
        $this->assertNotEmpty($token);
        $this->assertEquals(32, strlen($token));
    }
    
    public function testValidateToken()
    {
        $token = $this->csrf->generateToken();
        $this->assertTrue($this->csrf->validateToken($token));
        $this->assertFalse($this->csrf->validateToken('invalid-token'));
    }
}
