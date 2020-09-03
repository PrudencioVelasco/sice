<?php

class Autoload {

    public function __construct($class = NULL) {
        require_once dirname(__FILE__) . '/vendor/composer/autoload_real.php';
        return ComposerAutoloaderInit36c9cfc012e5a3f1d0f99f1d73346c3a::getLoader();
    }

}

?>