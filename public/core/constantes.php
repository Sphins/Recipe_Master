<?php

define('PUBLIC_ROOT', 'http://'
    . $_SERVER['HTTP_HOST']
    . '/'
    .  str_replace(DISPATCHER_NAME, '', $_SERVER['PHP_SELF']));

define('ADMIN_ROOT', str_replace(PUBLIC_FOLDER, ADMIN_FOLDER, PUBLIC_ROOT));
