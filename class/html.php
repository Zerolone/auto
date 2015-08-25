<?php
/**
 * 后台专用页面生成类
 * 
 * @version 2015-8-20 21:45:10
 * 
 */

class Html{
  public $title;  //页面名
  
  public $version = array('bootstrap'=>'3.3.5', 'jquery'=>'1.11.3');
  
  /**
   * 通过构造函数初始化成员变量
   */
  public function __construct($title=''){
    $this->title = $title;
    if($title=='') $this->title = '磐石后台v2';
  }
  
  public function create(){
    return $this->head().'{body}'.$this->foot();
  }
    
  /**
   * 表单头
   */
  private function head(){
    $strTmp = '<!DOCTYPE html>
      <html lang="zh-CN">
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>'.$this->title.'</title>
          <link href="lib/bootstrap'.$this->version['bootstrap'].'/css/bootstrap.min.css" rel="stylesheet">
        </head>
      <body>';
    return $strTmp;
  }

  /**
   * 表单尾  jquery1.11.3.min.js jquery2.1.4.min.js
   */
  public function foot(){
    $strTmp = '
        <script src="lib/jquery'.$this->version['jquery'].'.min.js"></script>
        <script src="lib/bootstrap'.$this->version['bootstrap'].'/js/bootstrap.min.js"></script>
      </body>
      </html>';
    return $strTmp;
  }
}