<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Controller/AboutController.php';

if (!function_exists('getDB')) {
    function getDB() {
        return null;
    }
}

if (!defined('TEMPLATE_PATH')) {
    define('TEMPLATE_PATH', __DIR__ . '/../templates/');
}

class AboutControllerTest extends TestCase
{
    private $controller;
    
    protected function setUp(): void
    {
        $auth = $this->createMock(Authentication::class);
        $this->controller = new AboutController($auth);
    }
    
    public function testAboutReturnsString()
    {
        $result = $this->controller->about();
        $this->assertIsString($result);
    }
    
    public function testAboutContainsAboutUs()
    {
        $result = $this->controller->about();
        $this->assertStringContainsString('About Us', $result);
    }
}
