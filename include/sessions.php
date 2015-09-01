<?php 
/*
$SESS_DBHOST = "localhost";
$SESS_DBNAME = "zerolone";
$SESS_DBUSER = "root";
$SESS_DBPASS = "root";

$SESS_DBH = ""; 
$SESS_LIFE = get_cfg_var("session.gc_maxlifetime"); 

function sess_open($save_path, $session_name) { 
    global $SESS_DBHOST, $SESS_DBNAME, $SESS_DBUSER, $SESS_DBPASS, $SESS_DBH; 

    if (! $SESS_DBH = mysql_pconnect($SESS_DBHOST, $SESS_DBUSER, $SESS_DBPASS)) { 
        echo "<li>;Can't connect to $SESS_DBHOST as $SESS_DBUSER"; 
        echo "<li>;MySQL Error: " . mysql_error(); 
        die; 
    } 

    if (! mysql_select_db($SESS_DBNAME, $SESS_DBH)) { 
        echo "<li>;Unable to select database $SESS_DBNAME"; 
        die; 
    } 

    return true; 
} 

function sess_close() { 
    return true; 
} 

function sess_read($key) { 
    global $SESS_DBH, $SESS_LIFE; 

    $qry = "SELECT value FROM `monolithpro_sessions` WHERE sesskey = '$key' AND expiry > " . time(); 
    $qid = mysql_query($qry, $SESS_DBH); 

    if (list($value) = mysql_fetch_row($qid)) { 
        return $value; 
    } 

    return false; 
} 

function sess_write($key, $val) { 
    global $SESS_DBH, $SESS_LIFE; 

    $expiry = time() + $SESS_LIFE; //过期时间 
    $value = addslashes($val); 

    $qry = "INSERT INTO `monolithpro_sessions` VALUES ('$key', $expiry, '$value')"; 
    $qid = mysql_query($qry, $SESS_DBH); 

    if (! $qid) { 
//        $qry = "UPDATE `monolithpro_sessions` SET expiry = $expiry, value = '$value' WHERE sesskey = '$key' AND expiry > " . time(); 
        $qry = "UPDATE `monolithpro_sessions` SET expiry = $expiry, value = '$value' WHERE sesskey = '$key'"; 
//				echo '<hr>' . $qry . '<hr>';
        $qid = mysql_query($qry, $SESS_DBH); 
    } 

    return $qid; 
} 

function sess_destroy($key) { 
    global $SESS_DBH; 

    $qry = "DELETE FROM `monolithpro_sessions` WHERE sesskey = '$key'"; 
    $qid = mysql_query($qry, $SESS_DBH); 

    return $qid; 
} 

function sess_gc($maxlifetime) { 
    global $SESS_DBH; 

    $qry = "DELETE FROM `monolithpro_sessions` WHERE expiry < " . time(); 
    $qid = mysql_query($qry, $SESS_DBH); 

    return mysql_affected_rows($SESS_DBH); 
} 

session_set_save_handler( 
"sess_open", 
"sess_close", 
"sess_read", 
"sess_write", 
"sess_destroy", 
"sess_gc"); 
//*/
session_start();
?>