<?php

require_once __DIR__ . '/../TestHelper.php';
require_once __DIR__ . '/../../src/Controller/Admin/LoginController.php';
require_once __DIR__ . '/../../src/Framework/DatabaseTable.php';
require_once __DIR__ . '/../../src/Framework/Authentication.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class LoginControllerTest extends TestCase
{
    private $controller;
    private $auth;

    protected function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->auth = $this->createMock(Authentication::class);
        $this->controller = new Admin\LoginController($this->auth);
    }

    public function testLoginFormReturnsString()
    {
        $this->auth->method('isLoggedIn')->willReturn(false);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = $this->controller->loginForm();
        $this->assertIsString($result);
    }

    public function testLoginFormContainsLogin()
    {
        $this->auth->method('isLoggedIn')->willReturn(false);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = $this->controller->loginForm();
        $this->assertStringContainsString('Login', $result);
    }

    public function testLogout()
    {
        $this->auth->expects($this->once())->method('logout');
        @$this->controller->logout();
        $this->assertTrue(true);
    }
}