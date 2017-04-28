<?php

require'vendor/autoload.php';

$app = new \atk4\ui\App('Money Lending App v0.1');
$app->initLayout('Centered');

$app->layout->add('Text')->addParagraph('This is an app tutorial. The very first version of our app does not have anything just yet.');
$app->layout->add(['Button', 'Read the tutorial', 'blue'])->link('https://github.com/atk4/money-lending-tutorial');
