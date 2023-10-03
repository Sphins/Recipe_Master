<?php
/* redirection en cas d acces direect au back office */

if (!isset($_SESSION['user'])) :
    header('location: ' . PUBLIC_ROOT);
endif;
