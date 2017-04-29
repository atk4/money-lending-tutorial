<?php
require'vendor/autoload.php';
$app = new \atk4\ui\App('Money Lending App v0.1');
$app->initLayout('Centered');
$app->layout->add('Text')->addParagraph('This is a very first version of your app that does not do anyting just yet.');
$app->layout->add(['Button', 'Read the tutorial', 'blue'])->link('https://github.com/atk4/money-lending-tutorial');
