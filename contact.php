<?php
require'lib.php';
$app = new MyApp();
$app->layout->add('CRUD')->setModel($app->user->ref('Contact'));
