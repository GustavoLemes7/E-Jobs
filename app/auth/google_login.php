<?php
require_once __DIR__ . '/../controller/GoogleAuthController.php';

$controller = new GoogleAuthController();
$controller->redirect();