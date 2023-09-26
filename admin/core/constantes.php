<?php

define('ADMIN_ROOT', rtrim('http://' . $_SERVER['HTTP_HOST'] . '/' . str_replace(DISPATCHER_NAME, '', $_SERVER['PHP_SELF']), '/'));


define('PUBLIC_ROOT', str_replace(ADMIN_FOLDER, PUBLIC_FOLDER, ADMIN_ROOT));
