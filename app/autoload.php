<?php

function __autoload($class) {
    if (file_exists(MODELS . "$class.class.php"))
        require_once MODELS . "$class.class.php";

    if (file_exists(CONTROLLERS . "$class.class.php"))
        require_once CONTROLLERS . "$class.class.php";

    if (file_exists(HELPERS . "$class.php"))
        require_once HELPERS . "$class.php";
}
