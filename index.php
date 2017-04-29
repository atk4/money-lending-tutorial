<?php
require'lib.php';

if (isset($_SESSION['user_id'])) {
    header('Location: contact.php');
    exit;
}

$app = new MyApp(false);

$app->layout->add(['Message','Use "john@gmail.com" / "test" to login');

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

    if ($m['password'] != $form->model['password']) {
        return $form->error('password', 'Incorrect password');
    }

    $_SESSION['user_id'] = $m->id;

    // Start Session

    return new \atk4\ui\jsExpression('document.location="contact.php"');
});


$app->layout->add(['Label', 'Developed with Agile Toolkit. Click to learn more.', 'right ribbon gray'])->link('https://github.com/atk4/money-lending-tutorial');
