<?php
if(SHOW_DEBUG==1){
  echo "页面执行时间 <strong>".getprocesstime($startime)."</strong> 秒|";
  echo Database::Get()->PrintDebug ();
}
?>