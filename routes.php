<?php

use Josh\Components\Navigation\Item;
use Josh\Components\Navigation\Facade\Navigation;

Navigation::group('auth', function(){

    Navigation::register('Logout', function(Item $item){

        $item->title('Logout');

        $item->uri('logout');
    });
});

Navigation::group('guest', function(){

    Navigation::register('login');

    Navigation::register('register');

});

Navigation::register('login');