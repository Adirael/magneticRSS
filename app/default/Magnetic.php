<?php

class Magnetic
{
    static function addItem($f3)
    {
        $db = $f3->get('db');

        if (empty($f3->get('REQUEST.magnetLink'))) {
            // TODO: Theme this
            echo 'You need to specify a magnetLink value.';

            return false;
        }

        $user = self::getUser($f3, array($f3->get('REQUEST.userToken'), $f3->get('REQUEST.userPassword')));

        if (!$user) {
            echo 'Invalid userToken or userPassword.';

            return false;
        }

        $item = new DB\SQL\Mapper($db, 'magnet_links');
        $item->load(array('userToken = ? AND magnetLink = ?', $f3->get('REQUEST.userToken'), $f3->get('REQUEST.magnetLink')));

        $item->userToken = $user->userToken;
        $item->magnetLink = $f3->get('REQUEST.magnetLink');
        $item->save();

        if (!$item->dry()) {
            // TODO: Theme this
            echo 'Magnet saved to database.';

            return false;
        }
    }

    static function getUser($f3, $request = null){
        $db = $f3->get('db');

        $user = new DB\SQL\Mapper($db, 'auth_tokens');

        if(is_null($request) && !empty($f3->get('SESSION.userToken'))){
            $user->load(array('userToken = ?', $f3->get('SESSION.userToken')));
        } else {
            $user->load(array('userToken = ? AND userPassword = ?', $request[0], $request[1]));
        }

        if(!$user->dry()){
            return $user;
        } else {
            return false;
        }
    }

    static function registerUser($f3)
    {
        $db = $f3->get('db');

        $user = new DB\SQL\Mapper($db, 'auth_tokens');
        $user->userToken = md5(microtime() . $f3->get('salt'));
        $user->userPassword = md5(microtime() . $user->userToken . $f3->get('salt'));
        $user->save();

        if (!$user->dry()) {
            // TODO: Theme this
            echo 'Your user has been created. Take note or your userToken: "' . $user->userToken . '" and your userPassword "' . $user->userPassword . '" to use the service.';
        } else {
            // TODO: Theme this
            echo 'There was an error creating your user, try again';
        }
    }

    static function getRSS($f3)
    {
        $db = $f3->get('db');

        $item = new DB\SQL\Mapper($db, 'magnet_links');
        $items = $item->find(array('userToken = ?', $f3->get('PARAMS.userToken')), array('order' => 'userToken'));

        $f3->set('items', $items);
        echo Template::instance()->render('rss.xml', 'application/xml');
    }

    static function loginUser($f3)
    {
        $db = $f3->get('db');

        if(empty($f3->get('PARAMS.userToken')) || empty($f3->get('PARAMS.userPassword'))){
            $user = self::getUser($f3, array($f3->get('REQUEST.userToken'), $f3->get('REQUEST.userPassword')));

            if($user){
                $f3->set('SESSION.userToken', $user->userToken);

                // TODO: Make this compatible with future JSON login
                $f3->reroute('/');
            } else {
                // TODO: Theme this
                echo 'Wrong user of password';
            }
        } else {
            // TODO: Theme this
            echo 'There was an error loggin you in';
        }
    }

    static function destroyUser($f3){
        $f3->clear('SESSION');
        $f3->reroute('/');
    }
}