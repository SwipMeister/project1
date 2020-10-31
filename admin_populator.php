<?php

// FILE runnen wanneer inserts klaar zijn en werken

include 'db.php';
$db = new Database('localhost', 'project1', 'root', '',  'utf8');

// functie signup met admin gegevens zodat we een admin user hebben
$db->signup('admin', 'admina', NULL, 'adminman', 'admin@test.nl', $db::ADMIN, 'administrator');

?>