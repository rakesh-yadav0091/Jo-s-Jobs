<?php
use Framework\Authentication;
use PHPUnit\Framework\TestCase;

class AdminJobsControllerTest extends TestCase
{
    private $controller;
    private $authentication;
    
    protected function setUp(): void
    {
        $this->authentication = $this->createMock(Authentication::class);
        $this->controller = new Admin\JobsController($this->authentication);
    }
    
    public function testList()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        $this->authentication->method('getUser')->willReturn(['role' => 'admin']);
        
        $result = $this->controller->list();
        $this->assertNotEmpty($result);
    }
    
    public function testArchive()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        $_POST['id'] = 1;
        
        try {
            $this->controller->archive();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
    
    public function testUnarchive()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        $_POST['id'] = 1;
        
        try {
            $this->controller->unarchive();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
    
    public function testClientList()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        $this->authentication->method('getUser')->willReturn(['role' => 'client']);
        
        $result = $this->controller->clientList();
        $this->assertNotEmpty($result);
    }
    
    public function testClientAdd()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        $this->authentication->method('getUser')->willReturn(['role' => 'client', 'id' => 1]);
        
        $_POST['title'] = 'Test Job';
        $_POST['description'] = 'Test Description';
        $_POST['salary'] = '50000';
        $_POST['closingDate'] = '2026-12-31';
        $_POST['categoryId'] = 1;
        $_POST['location'] = 'London';
        
        try {
            $this->controller->clientAdd();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
    
    public function testApplications()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        $this->authentication->method('getUser')->willReturn(['role' => 'admin']);
        
        $result = $this->controller->applications();
        $this->assertNotEmpty($result);
    }
    
    public function testUpdateApplication()
    {
        $this->authentication->method('isLoggedIn')->willReturn(true);
        $this->authentication->method('getUser')->willReturn(['role' => 'admin', 'id' => 1]);
        
        $_POST['applicantId'] = 1;
        $_POST['status'] = 'reviewing';
        $_POST['notes'] = 'Test notes';
        
        try {
            $this->controller->updateApplication();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('', $e->getMessage());
        }
    }
}
