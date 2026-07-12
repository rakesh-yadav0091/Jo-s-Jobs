<?php
use Framework\Authentication;
use PHPUnit\Framework\TestCase;

class AdminEnquiriesControllerTest extends TestCase
{
    private $controller;
    private $authentication;
    
    protected function setUp(): void
    {
        $this->authentication = $this->createMock(Authentication::class);
        $this->controller = new Admin\EnquiriesController($this->authentication);
    }
    
    public function testList()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        
        $result = $this->controller->list();
        $this->assertNotEmpty($result);
    }
    
    public function testComplete()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        $this->authentication->method('getUser')->willReturn(['id' => 1]);
        
        $_POST['id'] = 1;
        
        try {
            $this->controller->complete();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
}
