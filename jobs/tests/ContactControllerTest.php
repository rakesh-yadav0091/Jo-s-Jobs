<?php

require_once __DIR__ . '/TestHelper.php';
require_once __DIR__ . '/../src/Controller/ContactController.php';
require_once __DIR__ . '/../src/Framework/DatabaseTable.php';
require_once __DIR__ . '/../src/Framework/Authentication.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ContactControllerTest extends TestCase
{
    private $controller;
    private $auth;

    protected function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->auth = $this->createMock(Authentication::class);
        $this->controller = new ContactController($this->auth);
    }

    public function testContactReturnsString()
    {
        $result = $this->controller->contact();
        $this->assertIsString($result);
    }

    public function testContactContainsForm()
    {
        $result = $this->controller->contact();
        $this->assertStringContainsString('form', $result);
    }

    public function testContactContainsEmailField()
    {
        $result = $this->controller->contact();
        $this->assertStringContainsString('email', $result);
    }

    public function testContactContainsSubmitButton()
    {
        $result = $this->controller->contact();
        $this->assertStringContainsString('submit', $result);
    }
}