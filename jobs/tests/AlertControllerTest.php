<?php

require_once __DIR__ . '/TestHelper.php';
require_once __DIR__ . '/../src/Controller/AlertController.php';
require_once __DIR__ . '/../src/Framework/DatabaseTable.php';
require_once __DIR__ . '/../src/Framework/Authentication.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class AlertControllerTest extends TestCase
{
    private $controller;
    private $auth;

    protected function setUp(): void
    {
        $this->auth = $this->createMock(Authentication::class);
        $this->controller = new AlertController($this->auth);
    }

    public function testSubscribeFormReturnsString()
    {
        $result = $this->controller->subscribeForm();
        $this->assertIsString($result);
    }

    public function testSubscribeFormContainsAlert()
    {
        $result = $this->controller->subscribeForm();
        $this->assertStringContainsString('Alert', $result);
    }

    public function testSubscribeFormContainsEmailField()
    {
        $result = $this->controller->subscribeForm();
        $this->assertStringContainsString('email', $result);
    }
}