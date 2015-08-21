<?php
require 'class/html.php';

//默认html头尾
$html = new Html();  //参数可有可无，有默认值
$strHtml = $html->create();

echo $strHtml;

var_dump($_POST);

var_dump($_FILES);