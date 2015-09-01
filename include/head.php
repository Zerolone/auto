<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />

<!--样式表-->
<link href="../css/manage.css" type="text/css" rel="stylesheet">

<script language="JavaScript" src="../js/jquery-1.5.2.min.js"></script>
<script language="javascript" src="../js/message.js"></script>
<script language="JavaScript" src="../js/all.js"></script>
<script language="JavaScript" src="../js/trcolor.js"></script>
<script language="javascript" src="../js/edit.js"></script>
<script language="JavaScript">
function goto(pagenum){
  article_list_frm.pagenum.value  = pagenum;
  article_list_frm.submit();
}

$(function(){
  $('.menu,.menu1,.menu2').mouseover(function(){
    $(this).addClass('menuover');
  }).mouseleave(function(){
    $(this).removeClass('menuover');
  });
});  

</script>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<div id="Layer1" style="position:absolute; left:0px; top:0px; width:1px; height:1px; z-index:1; visibility:hidden">
  <table border="1" width="100%" id="table1" cellspacing="0" cellpadding="0" bordercolor="#000000" onClick="HiddenLayer();">
    <tr>
      <td><img src="../loading.gif" id="ViewImg" height="160"></td>
    </tr>
  </table>
</div>