<?php
/**
 * 通过PHP生成表单
 * 
 * @version 2015-8-20 23:29:52
 * @author  Zerolone
 */

require 'class/html.php';
require 'class/form.php';

//默认html头尾
$html = new Html('改变不了世界？来，咱们来商量下如何改变表单');  //参数可有可无，有默认值
$strHtml = $html->create();

$f = new Form('改变不了世界？来，咱们来商量下如何改变表单', 'form_submit.php', '_blank');   //参数可有可无，有默认值

//单行输入框--最简状态
$f->item(array(
  array('name'=>'inp_simple'),
));

//单行输入框
$f->item(array(
  array('name'=>'inp_simple2', 'width'=>'4', 'label'=>'带标签', 'labelWidth'=>2, 'placeholder'=>'单行带标签，标签长2，输入框长4'),
));

//输入框
$f->item(array(
  array('name'=>'inp_user',     'width'=>'4', 'label'=>'用户名', 'labelWidth'=>2,),
  array('name'=>'inp_password', 'width'=>'4', 'label'=>'密码',   'labelWidth'=>2, 'type'=>'password', 'placeholder'=>'请输入你的密码')
));

//多行输入框
$f->item(array(
  array('name'=>'inp_textarea', 'width'=>'10', 'label'=>'多行输入框', 'labelWidth'=>2, 'type'=>'textarea', 'value'=>'这里设置文本框的值'),
));

//文件上传
$f->item(array(
  array('name'=>'inp_upload', 'width'=>'10', 'label'=>'文件上传', 'labelWidth'=>2, 'placeholder'=>'我这个长度为10', 'type'=>"file"),
));


//下拉单选与多选
$options = array(
  array('val'=>1, 'text'=>'内容1'), 
  array('val'=>2, 'text'=>'内容2', 'selected' => 'selected'),
  array('val'=>3, 'text'=>'内容3', ),
  array('val'=>4, 'text'=>'内容4', ),
  array('val'=>5, 'text'=>'内容5', ),
);

$f->item(array(
  array('name'=>'sel_single', 'width'=>'4', 'label'=>'表单效果',  'labelWidth'=>2, 'type'=>'select', 'options'=> $options),
  array('name'=>'sel_muti',   'width'=>'4', 'label'=>'表单效果2', 'labelWidth'=>2, 'type'=>'select', 'options'=> $options, 'multiple'=>'multiple=multiple'),
));

//多选按钮
$options = array(
  array('val'=>6,  'text'=>'内容6'), 
  array('val'=>7,  'text'=>'内容7', 'checked' => 'checked'),
  array('val'=>8,  'text'=>'内容8', ),
  array('val'=>9,  'text'=>'内容9', 'checked' => 'checked'),
  array('val'=>10, 'text'=>'内容10', ),
);

$f->item(array(
  array('name'=>'chk_1', 'width'=>'4', 'label'=>'多选竖排',  'labelWidth'=>2, 'type'=>'checkbox', 'options'=> $options),
  array('name'=>'chk_2', 'width'=>'4', 'label'=>'多选横排', 'labelWidth'=>2, 'type'=>'checkbox', 'options'=> $options, 'inline'=>'-inline'),
));

//单选按钮
$options = array(
  array('val'=>11, 'text'=>'单选1'), 
  array('val'=>12, 'text'=>'单选2', 'checked' => 'checked'),
  array('val'=>13, 'text'=>'单选3', ),
  array('val'=>14, 'text'=>'单选4', 'checked' => 'checked'),
  array('val'=>15, 'text'=>'单选5', ),
);

$f->item(array(
  array('name'=>'rad_1', 'width'=>'4', 'label'=>'单选竖排',  'labelWidth'=>2, 'type'=>'radio', 'options'=> $options),
  array('name'=>'rad_2', 'width'=>'4', 'label'=>'单选横排', 'labelWidth'=>2, 'type'=>'radio', 'options'=> $options, 'inline'=>'-inline'),
));

//隐藏域
$f->item(array(
  array('name'=>'inp_hidden', 'type'=>'hidden', 'value'=>'inp_hidden_value'),
));

//普通按钮
$f->item(array(
  array('name'=>'btn1', 'width'=>'2', 'type'=>"button", 'value'=>"普通按钮1"),
  array('name'=>'btn2', 'width'=>'2', 'type'=>"button", 'value'=>"普通按钮-primary",  'style'=>'primary',),
  array('name'=>'btn3', 'width'=>'2', 'type'=>"button", 'value'=>"普通按钮-success",  'style'=>'success',),
  array('name'=>'btn4', 'width'=>'2', 'type'=>"button", 'value'=>"普通按钮-info",     'style'=>'info',),
  array('name'=>'btn5', 'width'=>'2', 'type'=>"button", 'value'=>"普通按钮-warning",  'style'=>'warning',),
  array('name'=>'btn6', 'width'=>'2', 'type'=>"button", 'value'=>"普通按钮-danger",   'style'=>'danger',),
));
  
//提交按钮
$f->item(array(
  array('name'=>'btnSubmit',  'width'=>'2', 'label'=>'', 'labelWidth'=>2, 'type'=>'submit', 'value'=>'提交按钮1'),
  array('name'=>'btnSubmit2', 'width'=>'2', 'label'=>'', 'labelWidth'=>2, 'type'=>'submit', 'value'=>'提交按钮primary', 'style'=>'primary'),
));




$strForm = $f->create();

//输出表格
echo str_replace('{body}', $strForm, $strHtml);exit();
