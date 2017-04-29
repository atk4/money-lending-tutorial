<?php
require'vendor/autoload.php';
session_start();

class User extends \atk4\data\Model {
    public $table = 'user';

    function init()
    {
        parent::init();

        $this->addFields([
            'email',
            ['password', 'type'=>'password'],
            'name',
            'surname'
        ]);

        $this->hasMany('Contact', new Contact());

    }
}

class Contact extends \atk4\data\Model {
    public $table = 'contact';

    function init()
    {
        parent::init();

        $this->addFields([
            'name','email','phone_number'
        ]);

        $this->hasOne('user_id', new User());
        $this->hasMany('Loan', new Loan());
    }
}

class Loan extends \atk4\data\Model {
    public $table = 'loan';

    function init()
    {
        parent::init();

        $this->hasOne('contact_id', new Contact());

        $this->addField('amount', ['type'=>'money']);
        $this->addField('due', ['type'=>'date']);
        $this->addField('repaid', ['type'=>'money']);
        $this->addField('is_active', ['type'=>'boolean']);
    }
}

class MyApp extends \atk4\ui\App {

    public $title = 'Money Lending App 0.2';

    public $db;

    public $user;

    function __construct($authenticate = true) {
        parent::__construct();

        if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
            // we are on Heroku
            preg_match('|([a-z]+)://([^:]*)(:(.*))?@([A-Za-z0-9\.-]*)(/([0-9a-zA-Z_/\.]*))|',
                $_ENV['CLEARDB_DATABASE_URL'],$matches);

            $dsn=array(
                $matches[1].':host='.$matches[5].';dbname='.$matches[7],
                $matches[2],
                $matches[4]
            );
            $this->db = new \atk4\data\Persistence_SQL($dsn[0], $dsn[1], $dsn[2]);
        } else {
            // Not on Heroku
            $this->db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=money_lending', 'root', 'root');
        }

        if (!$authenticate) {
            $this->initLayout('Centered');
            return;
        }

        if (!isset($_SESSION['user_id'])) {
            $this->initLayout('Centered');
            $this->layout->add(['Message', 'Login Required', 'error']);
            $this->layout->add(['Button', 'Login', 'primary'])->link('index.php');
            exit;
        }

        $this->user = new User($this->db);
        $this->user->load($_SESSION['user_id']);

        $this->initLayout('Admin');

        $this->layout->leftMenu->addItem(['Contacts', 'icon'=>'users'], 'contact.php');
        $this->layout->leftMenu->addItem(['Admin', 'icon'=>'lock'], 'admin.php');
        $this->layout->leftMenu->addItem(['Logout', 'icon'=>'sign out'], 'logout.php');
        $this->layout->menu->addItem('Logged in as '.$this->user['name']);

        /*

        $user_menu = $this->layout->menu->addMenu($this->user['name']);
        //$user_menu->addItem(['Profile', 'icon'=>'user'], 'profile.php');
         */
    }
}



