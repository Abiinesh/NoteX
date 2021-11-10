<?php

/** @var Connection $connection */
$connection = require_once 'pdo.php';

// Validate note object;

$note_id = $_POST['note_id'] ?? '';

if ($note_id){
    $connection->updateNote($note_id, $_POST);
}

else {
    $connection->addNote($_POST);
}

header('Location: index.php');
