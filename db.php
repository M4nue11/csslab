<?php
/**
 * Database connection — Savanna Edge Camp
 *
 * Matches XAMPP's default MySQL setup: user "root", no password.
 * If you set a MySQL password in XAMPP, update $DB_PASS below.
 */

$DB_HOST = 'localhost';
$DB_NAME = 'savanna_edge_camp';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO(
        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // For a class project it's fine to surface this directly so you can
    // see setup problems (e.g. forgot to import schema.sql, or MySQL
    // isn't running in the XAMPP control panel).
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()) .
        '<br>Check that MySQL is running in XAMPP and that you imported db/schema.sql.');
}
