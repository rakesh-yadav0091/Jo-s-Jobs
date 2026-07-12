<?php
/**
 * Front Controller - Entry point for all requests
 */
define('TEMPLATE_PATH', __DIR__ . '/../templates/');
require_once __DIR__ . '/../autoload.php';

function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=mysql;dbname=jobs;charset=utf8mb4',
                'student',
                'student'
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    return $pdo;
}

$routes = new Routes();
$authentication = new Authentication(new DatabaseTable(getDB(), 'users', 'id'));
$entryPoint = new EntryPoint($routes, $authentication);
$entryPoint->run();