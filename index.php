<?php
require'lib.php';

$app = new MyApp(false);


$form = $app->layout->add('Form');
$form->addField('email');
$form->addField('password');
$form->buttonSave->set('Login');

$form->onSubmit(function($form) { 

    $m = new User($form->app->db);
    $m->tryLoadBy('email', $form->model['email']);

    if (!$m->loaded()) { 
        return $form->error('email', 'No such user');
    }

    return 'OK for now';
});


$app->layout->add(['Label', 'Developed with Agile Toolkit. Click to learn more.', 'right ribbon gray'])->link('https://github.com/atk4/money-lending-tutorial');
