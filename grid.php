<?php
/**
 * 通过PHP生成表格
 * 
 * @version 2015-8-31 21:35:48
 * @author  Zerolone
 */

require 'include/common.php';
require 'class/html.php';
require 'class/grid.php';

//默认html头尾
$html = new Html('改变不了世界？来，咱们来商量下如何改变表格');  //参数可有可无，有默认值
$strHtml = $html->create();

$g = new Grid('改变不了世界？来，咱们来商量下如何改变表格');   //参数可有可无，有默认值

$page = Request('pagenum')+0; if($page<1)$page=1;
$pagesize = 10;

$params = array(
  'table'    => 'article',
  'column'   => '`id` as `编号` , `title` as `标题`, `posttime` as `时间`',
  'order'    => '`id` DESC',
  'page'     => $page,
  'pagesize' => $pagesize,
  
);

$g->params = $params;

$strGrid = $g->create();


//输出表格
echo str_replace('{body}', $strGrid, $strHtml);

//最后的js
echo $g->js;