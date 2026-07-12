<?php
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    private $authentication;
    private $databaseTable;
    
    protected function setUp(): void
    {
        $this->databaseTable = $this->createMock(DatabaseTable::class);
        $this->authentication = new Authentication($this->databaseTable);
    }
    
    public function testLoginSuccess()
    {
        // Mock successful login
        $this->databaseTable->method('findAll')->willReturn([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'active' => 1,
                'role' => 'admin'
            ]
        ]);
        
        $result = $this->authentication->login('admin', 'password123');
        $this->assertTrue($result);
    }
    
    public function testLoginFailure()
    {
        // Mock failed login
        $this->databaseTable->method('findAll')->willReturn([]);
        
        $result = $this->authentication->login('wronguser', 'wrongpass');
        $this->assertFalse($result);
    }
    
    public function testIsLoggedIn()
    {
        // Test when not logged in
        $this->assertFalse($this->authentication->isLoggedIn());
        
        // Test when logged in (by calling login first)
        $this->databaseTable->method('findAll')->willReturn([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'active' => 1
            ]
        ]);
        
        $this->authentication->login('admin', 'password123');
        $this->assertTrue($this->authentication->isLoggedIn());
    }
    
    public function testGetUser()
    {
        $this->databaseTable->method('findAll')->willReturn([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'active' => 1
            ]
        ]);
        
        $this->authentication->login('admin', 'password123');
        $user = $this->authentication->getUser();
        $this->assertIsArray($user);
        $this->assertEquals('admin', $user['username']);
    }
    
    public function testLogout()
    {
        $this->databaseTable->method('findAll')->willReturn([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'active' => 1
            ]
        ]);
        
        $this->authentication->login('admin', 'password123');
        $this->assertTrue($this->authentication->isLoggedIn());
        
        $this->authentication->logout();
        $this->assertFalse($this->authentication->isLoggedIn());
    }
}
