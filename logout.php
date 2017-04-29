<?php
require'lib.php';

unset($_SESSION['user_id']);
header('Location: index.php');
