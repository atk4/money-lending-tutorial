<?php
require'lib.php';
$app = new MyApp();
$app->layout->add('CRUD')->setModel(new User($app->db));
