<?php
use PHPUnit\Framework\TestCase;

class JobTest extends TestCase
{
    private $job;
    
    protected function setUp(): void
    {
        $this->job = new Job();
    }
    
    public function testProperties()
    {
        // Test setting and getting properties
        $this->job->id = 1;
        $this->assertEquals(1, $this->job->id);
        
        $this->job->title = 'Test Job';
        $this->assertEquals('Test Job', $this->job->title);
        
        $this->job->description = 'Test Description';
        $this->assertEquals('Test Description', $this->job->description);
        
        $this->job->salary = '50000';
        $this->assertEquals('50000', $this->job->salary);
    }
}
