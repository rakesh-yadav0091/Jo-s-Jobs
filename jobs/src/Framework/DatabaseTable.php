<?php
/**
 * DatabaseTable Class - Database abstraction layer
 */
class DatabaseTable {
    private $pdo;
    private $table;
    private $primaryKey;
    
    public function __construct(PDO $pdo, string $table, string $primaryKey) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }
    
    public function findAll($orderBy = null, $where = null, $params = [], $limit = null) {
        $sql = "SELECT * FROM " . $this->table;
        if ($where !== null) {
            $sql .= " WHERE " . $where;
        }
        if ($orderBy !== null) {
            $sql .= " ORDER BY " . $orderBy;
        }
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE " . $this->primaryKey . " = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    public function save($record) {
        if (empty($record[$this->primaryKey])) {
            unset($record[$this->primaryKey]);
            return $this->insert($record);
        } else {
            return $this->update($record);
        }
    }
    
    private function insert($record) {
        $columns = array_keys($record);
        $placeholders = ':' . implode(', :', $columns);
        $sql = "INSERT INTO " . $this->table . " (" . implode(', ', $columns) . ") VALUES (" . $placeholders . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($record);
        return $this->pdo->lastInsertId();
    }
    
    private function update($record) {
        $columns = array_keys($record);
        $set = [];
        foreach ($columns as $col) {
            if ($col !== $this->primaryKey) {
                $set[] = $col . " = :" . $col;
            }
        }
        $sql = "UPDATE " . $this->table . " SET " . implode(', ', $set) . " WHERE " . $this->primaryKey . " = :" . $this->primaryKey;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($record);
        return $record[$this->primaryKey];
    }
}