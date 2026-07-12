<?php

require_once __DIR__ . '/TestHelper.php';
require_once __DIR__ . '/../src/Controller/ApplyController.php';
require_once __DIR__ . '/../src/Framework/DatabaseTable.php';
require_once __DIR__ . '/../src/Framework/Authentication.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ApplyControllerTest extends TestCase
{
    private $controller;
    private $auth;

    protected function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->auth = $this->createMock(Authentication::class);
        $this->controller = new ApplyController($this->auth);
    }

    public function testShowFormReturnsString()
    {
        $_GET['id'] = 1;
        $result = $this->controller->showForm();
        $this->assertIsString($result);
    }

    public function testShowFormContainsApply()
    {
        $_GET['id'] = 1;
        $result = $this->controller->showForm();
        $this->assertStringContainsString('Apply', $result);
    }

    public function testShowFormContainsForm()
    {
        $_GET['id'] = 1;
        $result = $this->controller->showForm();
        $this->assertStringContainsString('form', $result);
    }
}