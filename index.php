<?php

// F3 Init
$f3 = require('lib/base.php');

// Configuration
$f3->config('app/config.ini');
$f3->set('AUTOLOAD', 'app/default/');
$f3->set('UI', 'ui/');
$f3->set('db', $db = new DB\SQL('mysql:host='.$f3->get('mysql_host').';port='.$f3->get('mysql_port').';dbname='.$f3->get('mysql_db'), $f3->get('mysql_user'), $f3->get('mysql_password')));

// Front page
$f3->route('GET /',
    function () {
        echo Template::instance()->render('html/home.html');
    }
);

// Creates a new user (userToken and userPassword are autogenerated)
$f3->route('GET /addUser', 'Magnetic::registerUser');

// Displays a RSS file with the magnets for a @usertoken
$f3->route('GET /@userToken/rss', 'Magnetic::getRSS');

// Adds a new magnet to a user, this expets a POST request
$f3->route('POST /add', 'Magnetic::addItem');

$f3->run();
