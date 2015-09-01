<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="STYLESHEET" type="text/css" href="/css/manage.css">
</head>

<script type="text/javascript">
var duration= <?=REFRESH_TIME?>*1000 - 100;
var endTime = new Date().getTime() + duration + 100;
function interval(){
  var n=(endTime-new Date().getTime())/1000;
  if(n<0) return;
  document.getElementById("timeout").innerHTML = n.toFixed(3);
  setTimeout(interval, 10);
}

window.onload=function(){
  setTimeout("window.location.href='<?=$refresh_url?>'", duration);
  interval();
}
</script>

<body>
<table border="0" width="100%" id="table1" height="100%" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#666666" width="90%" height="90" align="center">
        <tr>
          <td bgcolor="#F7F7F7">
          <p align="center"><br><font color="blue">提示信息 : <?=$refresh_msg?></font><br><br>( <a href="<?=$refresh_url?>">过 <span id="timeout"><?=REFRESH_TIME?>.000</span> 秒后,页面将自动跳转,或者,您也可以点击这里</a> )<br><br></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>

</html>