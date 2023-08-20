<?php
session_start();
require_once '../backend/class/bdd.php';
$databases = new Database();
$databases->requette('DELETE FROM conmdp');
session_destroy();
header('location: ../index.php');
?>