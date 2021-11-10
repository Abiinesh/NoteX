<?php

/** @var Connection $connection */
$connection = require_once 'pdo.php';

$connection->removeNote($_POST['note_id']);

header('Location: index.php');
