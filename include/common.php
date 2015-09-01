<?php
//配置函数
if (strpos ( ' ' . $_SERVER ["HTTP_HOST"], 'mingyihui.cc' ) || strpos ( ' ' . $_SERVER ["HTTP_HOST"], 'localhost' )) {  
  require('include/config_local.php');  //本地调试用Config文件
}else{
  require('include/config.php');        //网络用Config文件
}
session_start();                     //session
require('include/function.php');     //函数地址

require('class/'.DB_TYPE.'.php'); $MyDatabase  = Database::Get();   //数据库类

//默认参数
$pagenum     = Request('pagenum')+0; if($pagenum==0)$pagenum=1;  //读取页数
$pagesize    = 20;                    //每页显示数
$recordcount = 0;                      //记录数
$refresh_msg = '[<font color=blue>不成功</font>]，返回首页。';
$refresh_txt = '失败';
?>