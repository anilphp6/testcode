<?php
/**
 * api loaded
 */

class API_loader {

    static public function auth() {

        spl_autoload_extensions(".php");
        spl_autoload_register();
    }

}
