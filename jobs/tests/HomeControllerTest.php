<?php

require_once __DIR__ . '/TestHelper.php';
require_once __DIR__ . '/../src/Controller/HomeController.php';
require_once __DIR__ . '/../src/Framework/DatabaseTable.php';
require_once __DIR__ . '/../src/Framework/Authentication.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    private $controller;
    private $auth;

    protected function setUp(): void
    {
        $this->auth = $this->createMock(Authentication::class);
        $this->controller = new HomeController($this->auth);
    }

    public function testHomeReturnsString()
    {
        $result = $this->controller->home();
        $this->assertIsString($result);
    }

    public function testHomeContainsCategories()
    {
        $result = $this->controller->home();
        $this->assertStringContainsString('category-grid', $result);
    }

    public function testHomeContainsWelcomeMessage()
    {
        $result = $this->controller->home();
        $this->assertStringContainsString('Welcome', $result);
    }

    public function testHomeContainsClosingSoon()
    {
        $result = $this->controller->home();
        $this->assertStringContainsString('closingSoon', $result);
    }
}