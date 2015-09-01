<?php
/**
 * 后台登陆检测页面
 * 
 * @author  Zerolone
 * @version 2015-7-21 10:55:22
 */

$ThisPage = $_SERVER ['PHP_SELF'];
$ThePage1 = 'login.php';
$ThePage2 = 'logincheck.php';

//如果session不存在，则
if (!isset ( $_SESSION ['login'] )) {
  $_SESSION ['login'] = 0;
}

if ($_SESSION ['login'] != 1 && $ThisPage != $ThePage1 && $ThisPage != $ThePage2) {
  $page_name = 'include/refresh.php';  
  
  $refresh_msg = '你尚未登陆或登录超时，请重新登录。';
  $refresh_url = 'login.php';
  
  require ($page_name . '.php');
  die ();
}
?>