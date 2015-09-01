<?php
/**
 * 创建一个验证码
 * @version 2011-1-27 17:29:18
 * 
 * 
 */
define('CPNUM', 1); //定义显示个数

//创建一个真彩色图像
$im=imagecreatetruecolor(64,16);

//设定一个背景边框色
$borderColor=imagecolorallocate($im, 255, 0, 0);

//设定一个背景色
//$backgroundColor=imagecolorallocate($im,51,153,204);
$backgroundColor=imagecolorallocate($im, 0, 0, 0);

//填充背景色。
//imagefill($im,0,0,$backgroundColor);

//绘制外框
//imagerectangle($im,1,1,55,20,$borderColor);

//初始化验证码
$text='';

//创建一个随机函数包所需要的范围..
//$textAll = array_merge_recursive(range('A','Z'),range('a','z'),range('0','9'));
//$textAll = array_merge_recursive(range('a','z'),range('2','9'));
$textAll = array(1,2,3,4,5,6,7,8,9);
for($i=1; $i<=CPNUM; $i++){
     //随机取出一位数。
     $ai=rand(0,9);
     $text.=$textAll[$ai];
}

//添加杂点。
//*
for($i=1;$i<=60;$i++){
     $randColor=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
     imagesetpixel($im,rand(1,55),rand(1,26),$randColor);
}
//*/


//添加划痕
//*
for($i=1;$i<=6;$i++){
     $randColor=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
     imageline($im,rand(1,55),rand(1,20),rand(1,55),rand(1,20),$randColor);
}
//*/

//添加文字
imagestring($im,20,1,1,$text,$borderColor);

ImageColorTransparent($im,$backgroundColor);

ImageGif($im);

session_start(); 
$_SESSION['usercheck']=$text;

//输出
header('Content-type:image/gif');
imagejpeg($im);
?>	