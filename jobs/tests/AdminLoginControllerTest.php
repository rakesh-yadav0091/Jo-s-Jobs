<?php
use PHPUnit\Framework\TestCase;
use Framework\Authentication;

class AdminLoginControllerTest extends TestCase
{
    private $controller;
    private $authentication;
    
    protected function setUp(): void
    {
        $this->authentication = $this->createMock(Authentication::class);
        $this->controller = new Admin\LoginController($this->authentication);
    }
    
    public function testLoginForm()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = $this->controller->loginForm();
        $this->assertNotEmpty($result);
    }
    
    public function testLoginFormWithPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'admin';
        $_POST['password'] = 'password';
        
        $this->authentication->method('login')->willReturn(true);
        $this->authentication->method('getUser')->willReturn(['role' => 'admin']);
        
        try {
            $this->controller->loginForm();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
    
    public function testLogout()
    {
        try {
            $this->controller->logout();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
}