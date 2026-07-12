<?php

require_once __DIR__ . '/TestHelper.php';
require_once __DIR__ . '/../src/Controller/JobsController.php';
require_once __DIR__ . '/../src/Framework/DatabaseTable.php';
require_once __DIR__ . '/../src/Framework/Authentication.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Controller\JobsController;
use App\Framework\Authentication;

class JobsControllerTest extends TestCase
{
    private $controller;
    private $auth;

    protected function setUp(): void
    {
        $this->auth = $this->createMock(Authentication::class);
        $this->controller = new JobsController($this->auth);
    }

    public function testListReturnsString()
    {
        $_GET['id'] = 1;
        $result = $this->controller->list();
        $this->assertIsString($result);
    }

    public function testListWithSearchTitle()
    {
        $_GET['id'] = 1;
        $_GET['title'] = 'Developer';
        $result = $this->controller->list();
        $this->assertIsString($result);
    }

    public function testListWithSearchLocation()
    {
        $_GET['id'] = 1;
        $_GET['location'] = 'Northampton';
        $result = $this->controller->list();
        $this->assertIsString($result);
    }

    public function testListWithSalaryFilter()
    {
        $_GET['id'] = 1;
        $_GET['min_salary'] = '20000';
        $_GET['max_salary'] = '50000';
        $result = $this->controller->list();
        $this->assertIsString($result);
    }
}