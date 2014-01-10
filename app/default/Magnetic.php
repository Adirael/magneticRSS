<?php

class Magnetic
{
    static function addItem($f3)
    {
        // phpStorm highlighting is broken, that's why I need to define the var instead of directly passing it
        $magnetLink = $f3->get('REQUEST.magnetLink');

        if (empty($magnetLink)) {
            echo 'You need to specify a magnetLink value.';

            return false;
        }

        $db = $f3->get('db');

        $user = new DB\SQL\Mapper($db, 'auth_tokens');
        $user->load(array('userToken = ? AND userPassword = ?', $f3->get('REQUEST.userToken'), $f3->get('REQUEST.userPassword')));

        if ($user->dry() || $user->userPassword != $f3->get('REQUEST.userPassword')) {
            echo 'Invalid userToken or userPassword.';

            return false;
        }

        $item = new DB\SQL\Mapper($db, 'magnet_links');
        $item->load(array('userToken = ? AND magnetLink = ?', $f3->get('REQUEST.userToken'), $f3->get('REQUEST.magnetLink')));

        $item->userToken = $user->userToken;
        $item->magnetLink = $f3->get('REQUEST.magnetLink');
        $item->save();

        if (!$item->dry()) {
            echo 'Magnet saved to database.';

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
            echo 'Your user has been created. Take note or your userToken: "' . $user->userToken . '" and your userPassword "' . $user->userPassword . '" to use the service.';
        } else {
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
}