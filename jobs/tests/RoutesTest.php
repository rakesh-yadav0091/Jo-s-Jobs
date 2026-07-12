<?php
use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase
{
    private $routes;
    
    protected function setUp(): void
    {
        $this->routes = new Routes();
    }
    
    // ===== ADMIN ROUTES TESTS =====
    public function testAdminLoginRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/login', 'GET');
        $this->assertEquals(['Admin\LoginController', 'loginForm'], $result);
    }
    
    public function testAdminLogoutRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/logout', 'GET');
        $this->assertEquals(['Admin\LoginController', 'logout'], $result);
    }
    
    public function testAdminJobsRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/jobs', 'GET');
        $this->assertEquals(['Admin\JobsController', 'list'], $result);
    }
    
    public function testAdminJobsArchiveRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/jobs/archive', 'POST');
        $this->assertEquals(['Admin\JobsController', 'archive'], $result);
    }
    
    public function testAdminJobsUnarchiveRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/jobs/unarchive', 'POST');
        $this->assertEquals(['Admin\JobsController', 'unarchive'], $result);
    }
    
    public function testAdminUsersRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/users', 'GET');
        $this->assertEquals(['Admin\UsersController', 'list'], $result);
    }
    
    public function testAdminUsersAddRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/users/add', 'POST');
        $this->assertEquals(['Admin\UsersController', 'add'], $result);
    }
    
    public function testAdminUsersDeleteRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/users/delete', 'POST');
        $this->assertEquals(['Admin\UsersController', 'delete'], $result);
    }
    
    public function testAdminEnquiriesRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/enquiries', 'GET');
        $this->assertEquals(['Admin\EnquiriesController', 'list'], $result);
    }
    
    public function testAdminEnquiriesCompleteRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/enquiries/complete', 'POST');
        $this->assertEquals(['Admin\EnquiriesController', 'complete'], $result);
    }
    
    public function testAdminApplicationsRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/applications', 'GET');
        $this->assertEquals(['Admin\JobsController', 'applications'], $result);
    }
    
    public function testAdminApplicationsUpdateRoute()
    {
        $result = $this->routes->getControllerAndMethod('admin/applications/update', 'POST');
        $this->assertEquals(['Admin\JobsController', 'updateApplication'], $result);
    }
    
    // ===== CLIENT ROUTES TESTS =====
    public function testClientJobsRoute()
    {
        $result = $this->routes->getControllerAndMethod('client/jobs', 'GET');
        $this->assertEquals(['Admin\JobsController', 'clientList'], $result);
    }
    
    public function testClientJobsAddRoute()
    {
        $result = $this->routes->getControllerAndMethod('client/jobs/add', 'POST');
        $this->assertEquals(['Admin\JobsController', 'clientAdd'], $result);
    }
    
    public function testClientApplicantsRoute()
    {
        $result = $this->routes->getControllerAndMethod('client/applicants', 'GET');
        $this->assertEquals(['Admin\JobsController', 'clientApplicants'], $result);
    }
    
    // ===== ALERT ROUTES TESTS =====
    public function testAlertSubscribeFormRoute()
    {
        $result = $this->routes->getControllerAndMethod('alert/subscribe', 'GET');
        $this->assertEquals(['AlertController', 'subscribeForm'], $result);
    }
    
    public function testAlertSubscribeRoute()
    {
        $result = $this->routes->getControllerAndMethod('alert/subscribe', 'POST');
        $this->assertEquals(['AlertController', 'subscribeForm'], $result);
    }
    
    public function testAlertUnsubscribeRoute()
    {
        $result = $this->routes->getControllerAndMethod('alert/unsubscribe', 'GET');
        $this->assertEquals(['AlertController', 'unsubscribe'], $result);
    }
    
    // ===== SAVED JOBS ROUTES TESTS =====
    public function testJobsSaveRoute()
    {
        $result = $this->routes->getControllerAndMethod('jobs/save', 'POST');
        $this->assertEquals(['JobsController', 'saveJob'], $result);
    }
    
    public function testJobsSavedRoute()
    {
        $result = $this->routes->getControllerAndMethod('jobs/saved', 'GET');
        $this->assertEquals(['JobsController', 'savedJobs'], $result);
    }
    
    // ===== FRONTEND ROUTES TESTS =====
    public function testAboutRoute()
    {
        $result = $this->routes->getControllerAndMethod('about', 'GET');
        $this->assertEquals(['AboutController', 'about'], $result);
    }
    
    public function testCareersRoute()
    {
        $result = $this->routes->getControllerAndMethod('careers', 'GET');
        $this->assertEquals(['CareersController', 'advice'], $result);
    }
    
    public function testContactRoute()
    {
        $result = $this->routes->getControllerAndMethod('contact', 'GET');
        $this->assertEquals(['ContactController', 'contact'], $result);
    }
    
    public function testApplyShowFormRoute()
    {
        $result = $this->routes->getControllerAndMethod('apply', 'GET');
        $this->assertEquals(['ApplyController', 'showForm'], $result);
    }
    
    public function testApplySubmitRoute()
    {
        $result = $this->routes->getControllerAndMethod('apply', 'POST');
        $this->assertEquals(['ApplyController', 'submit'], $result);
    }
    
    public function testJobsListRoute()
    {
        $result = $this->routes->getControllerAndMethod('jobs', 'GET');
        $this->assertEquals(['JobsController', 'list'], $result);
    }
    
    // ===== DEFAULT ROUTE TEST =====
    public function testDefaultRoute()
    {
        $result = $this->routes->getControllerAndMethod('unknown/route', 'GET');
        $this->assertEquals(['HomeController', 'home'], $result);
    }
    
    public function testDefaultRouteWithDifferentMethod()
    {
        $result = $this->routes->getControllerAndMethod('unknown/route', 'POST');
        $this->assertEquals(['HomeController', 'home'], $result);
    }
}
