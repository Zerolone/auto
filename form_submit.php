<?php
require 'class/html.php';

//Ĭ��htmlͷβ
$html = new Html();  //�������п��ޣ���Ĭ��ֵ
$strHtml = $html->create();

echo $strHtml;

var_dump($_POST);

var_dump($_FILES);