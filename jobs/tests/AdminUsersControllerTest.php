<?php
use Framework\Authentication;
use PHPUnit\Framework\TestCase;

class AdminUsersControllerTest extends TestCase
{
    private $controller;
    private $authentication;
    
    protected function setUp(): void
    {
        $this->authentication = $this->createMock(Authentication::class);
        $this->controller = new Admin\UsersController($this->authentication);
    }
    
    public function testList()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        
        $result = $this->controller->list();
        $this->assertNotEmpty($result);
    }
    
    public function testAdd()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        
        $_POST['username'] = 'testuser';
        $_POST['password'] = 'password123';
        $_POST['name'] = 'Test User';
        $_POST['email'] = 'test@example.com';
        $_POST['role'] = 'staff';
        
        try {
            $this->controller->add();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
    
    public function testDelete()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        $this->authentication->method('getUser')->willReturn(['id' => 2]);
        
        $_POST['id'] = 1;
        
        try {
            $this->controller->delete();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
}
