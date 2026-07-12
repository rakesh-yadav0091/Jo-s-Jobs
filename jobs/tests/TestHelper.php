<?php
if (!defined("TEMPLATE_PATH")) {
    define("TEMPLATE_PATH", __DIR__ . "/../templates/");
}

if (!function_exists("getDB")) {
    function getDB() {
        $pdo = new PDO("sqlite::memory:");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create category table
        $pdo->exec("CREATE TABLE IF NOT EXISTS category (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL
        )");
        $pdo->exec("INSERT OR IGNORE INTO category (id, name) VALUES (1, 'Information Technology')");
        $pdo->exec("INSERT OR IGNORE INTO category (id, name) VALUES (2, 'Human Resources')");

        // Create job table
        $pdo->exec("CREATE TABLE IF NOT EXISTS job (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            description TEXT,
            salary TEXT,
            closingDate DATE,
            categoryId INTEGER,
            location TEXT,
            dateReceived DATE,
            archived INTEGER DEFAULT 0,
            clientId INTEGER
        )");
        $pdo->exec("INSERT OR IGNORE INTO job (id, title, description, salary, closingDate, categoryId, location, dateReceived) 
                    VALUES (1, 'Test Job', 'Description', '30000', DATE('now', '+10 days'), 1, 'Northampton', DATE('now'))");

        // Create users table
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            name TEXT NOT NULL,
            email TEXT,
            role TEXT DEFAULT 'staff',
            active INTEGER DEFAULT 1
        )");

        return $pdo;
    }
}