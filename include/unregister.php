<?php
 // Emulate register_globals off
 function unregister_GLOBALS()
 {
     if (!ini_get('register_globals')) {
         return;
     }

    // Might want to change this perhaps to a nicer error
     if (isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS'])) {
         die('GLOBALS overwrite attempt detected');
     }

    // Variables that shouldn't be unset
     $noUnset = array('GLOBALS', '_GET',
                      '_POST',    '_COOKIE',
                      '_REQUEST', '_SERVER',
                      '_ENV',     '_FILES');

    $input = array_merge($_GET,    $_POST,
                          $_COOKIE, $_SERVER,
                          $_ENV,    $_FILES,
                          isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());

    foreach ($input as $k => $v) {
         if (!in_array($k, $noUnset) && isset($GLOBALS[$k])) {
             unset($GLOBALS[$k]);
         }
     }
 }

unregister_GLOBALS();

?>