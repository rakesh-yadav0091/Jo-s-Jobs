<?php
require_once __DIR__ . "/TestHelper.php";
require_once __DIR__ . "/../src/Framework/DatabaseTable.php";
use PHPUnit\Framework\TestCase;

class DatabaseTableTest extends TestCase {
    private $table;

    protected function setUp(): void {
        $pdo = new PDO("sqlite::memory:");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $pdo->exec("CREATE TABLE test (id INTEGER PRIMARY KEY, name TEXT)");
        $pdo->exec("INSERT INTO test (name) VALUES ('Test1')");
        $pdo->exec("INSERT INTO test (name) VALUES ('Test2')");
        
        $this->table = new DatabaseTable($pdo, "test", "id");
    }

    public function testFindAll() {
        $result = $this->table->findAll();
        $this->assertCount(2, $result);
    }

    public function testFindById() {
        $result = $this->table->findById(1);
        $this->assertEquals("Test1", $result["name"]);
    }

    public function testInsert() {
        $id = $this->table->save(["name" => "New"]);
        $this->assertNotNull($id);
    }

    public function testUpdate() {
        $this->table->save(["id" => 1, "name" => "Updated"]);
        $result = $this->table->findById(1);
        $this->assertEquals("Updated", $result["name"]);
    }
}