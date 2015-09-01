<?php
/**
 * 公共函数放置位置
 * 文件名 function.php
 *
 * @author  Zerolone
 * @version 2014-9-13 14:51:24
 */

/**
 * 打印空格
 *
 * @param $num 空格数
 * @return 一片空格
 */
function LoopNBSP($num=1){
  $thestr='';
  for($i=0;$i<$num;$i++){
    $thestr .= '&nbsp;';
  }
  return $thestr;
}

/**
 * 获取执行时间
 *
 * @param $start_time 时间
 * @return 时间差距
 */
function getprocesstime($start_time="0 0"){
  list($start_usec, $start_sec, $end_usec, $end_sec) = explode(" ",$start_time . " " . microtime());
  $temp1 = ((float)$start_usec + (float)$start_sec)*1000;
  $temp2 = ((float)$end_usec + (float)$end_sec)*1000;
  $temp  = $temp2-$temp1 ;
  $temp /= 1000;
  return number_format($temp, 4, '.', '');
}

/**
 * 字符串截取，仅支持UTF8
 *
 * @param 截取字符串 $str
 * @param 长度       $len
 * @return 截取后的字符串
 */
function subString ($str,$len){
  for($i=0;$i<$len;$i++){
    $temp_str=substr($str,0,1);
    if(ord($temp_str) > 127){
      $i++;
      if($i<$len){
        $new_str[]=substr($str,0,3);
        $str=substr($str,3);
      }
    }else{
      $new_str[]=substr($str,0,1);
      $str=substr($str,1);
    }
  }
  return join($new_str);
}

/**
 * 字符串编码不打算恢复的
 *
 * @param 字符串 $str
 * @return 字符串
 */
function Encode ( $str ){
  $str= str_replace("<", "&lt;", $str);
  $str= str_replace(">", "&gt;", $str);
  $str= str_replace("'", "\'", $str);
  $str= str_replace('"', '“', $str);
  $str= str_replace("\r\n", "<br />", $str);
  return $str;
}

/**
 * 字符串编码
 *
 * @param 字符串 $Content
 * @return 编码后的字符串
 */
function EnCodeStr($Content){
  //替换空格
  $Content  = str_replace(" ", "[z_space]", $Content);

  //替换换行
  $Content  = str_replace("\r\n", "[z_newline]", $Content);

  //替换<>
  $Content  = str_replace("<", "[z_l]", $Content);
  $Content  = str_replace(">", "[z_r]", $Content);

  //替换Tab
  $Content  = str_replace(chr(9), "[z_tab]", $Content);

  //替换单双引号
  $Content  = str_replace("'", "[z_sq]", $Content);
  $Content  = str_replace('"', "[z_dq]", $Content);

  return $Content;
}

/**
 * 字符串解码,与EnCodeStr配合使用
 *
 * @param 字符串 $Content
 * @return 字符串
 */
function DeCodeStr($Content){
  //替换空格
  $Content  = str_replace("[z_space]", " ", $Content);

  //替换换行
  $Content  = str_replace("[z_newline]", "\r\n", $Content);

  //替换<>
  $Content  = str_replace("[z_l]", "<", $Content);
  $Content  = str_replace("[z_r]", ">", $Content);

  //替换Tab
  $Content  = str_replace("[z_tab]", chr(9), $Content);

  //替换单双引号
  $Content  = str_replace("[z_sq]", "'", $Content);
  $Content  = str_replace('[z_dq]', '"', $Content);

  return $Content;
}

/**
 * 字符串解码显示
 *
 * @param 字符串 $Content
 * @return 字符串
 */
function DeCodeStrView($Content){
  //替换空格
  $Content  = str_replace("[z_space]", " ", $Content);

  //替换换行
  $Content  = str_replace("[z_newline]", "<br>", $Content);

  //替换<>
  $Content  = str_replace("[z_l]", "&lt;", $Content);
  $Content  = str_replace("[z_r]", "&gt;", $Content);

  //替换<br>
  $Content  = str_replace("&ltbr;&gt;", "<br>", $Content);

  //替换Tab
  $Content  = str_replace("[z_tab]", chr(9), $Content);

  //替换单双引号
  $Content  = str_replace("[z_sq]", "'", $Content);
  $Content  = str_replace('[z_dq]', '"', $Content);

  return $Content;
}

/**
 * 非法字符串删除
 *
 * @param 字符串 $Content
 * @return 编码后的字符串
 */
function DelCodeStr($Content){
  //替换HTML代码
  $Content         = strip_tags($Content);

  //替换空格
  $Content  = str_replace(" ", "", $Content);

  //替换换行
  $Content  = str_replace("\r\n", "", $Content);

  //替换Tab
  $Content  = str_replace(chr(9), "", $Content);

  //替换单双引号
  $Content  = str_replace("'", "", $Content);
  $Content  = str_replace('"', "", $Content);

  //全角空格
  $Content  = str_replace('　', '', $Content);

  return $Content;
}

/**
 * 字符串切割
 *
 * @param $Content    需要切割的字符串
 * @param $StartFlag  起始标志
 * @param $EndFlag    结束标志
 * @param $Code       切割后连接方式，1为将起始、结束标志连接 2为加上前后
 * @return $TheContent
 */
function CutStr($Content, $StartFlag, $EndFlag, $Code=0){
  //echo "<hr size=1 color=blue> 内 容 长 度 ：".strlen($Content);

  $pos1 = strpos($Content, $StartFlag);
  $pos2 = strpos($Content, $EndFlag, $pos1);
  $StartFlag_Len  = strlen($StartFlag);
  $TheContent    = substr($Content, $pos1+$StartFlag_Len, $pos2-$pos1-$StartFlag_Len);

  if ($Code==1){
    $TheContent = str_replace($StartFlag.$TheContent.$EndFlag, '', $Content);
  }
  
  if ($Code==2){
    $TheContent = $StartFlag.$TheContent.$EndFlag;
  }
  

  /*/
   echo "<br>开始标志位置：".$pos1;
   echo "<br>开始标志长度：".$StartFlag_Len;
   echo "<br>结束标志位置：".$pos2;
   echo "<br>结束标志长度：".$EndFlag_Len;
   echo "<br>起始截取位置：".($pos1+$StartFlag_Len);
   echo "<br>总共截取长度：".($pos2-$pos1-$EndFlag_Len-$StartFlag_Len+1);
   echo "<hr size=1 color=black>内容为：".$TheContent;
   echo "<hr size=1 color=blue>";
   //*/

  return $TheContent;

}

/**
 * 保存图片文件，并入库
 *
 * @param $fileName   文件名
 * @param $ImagePath  保存路径
 * @param $ImageUrl   远程路径
 */
function savePic( $fileName ,$ImagePath, $ImageUrl){
  $s_filename = basename( $fileName );
  $ext_name = strtolower( strrchr( $s_filename, "." ) );

  if( ( ".jpg" && ".gif" && ".png" && ".bmp" ) != strtolower( $ext_name ) )  {
    return "";
  }

  $url='';
  if( 0 == strpos( $fileName, "/" ) )  {
    preg_match( "@http://(.*?)/@i", $this->URL, $url );
    $url = $url[0];
  }

  $contents = file_get_contents( $url . $fileName );
  $s_filename = date( "His", time() ) . rand( 1000, 9999 ) . $ext_name;

  //file_put_contents( $this->saveImagePath.$s_filename, $contents );

  $handle = fopen ( $ImagePath.$s_filename, "w" );
  fwrite( $handle, $contents );
  fclose($handle);

  $ArrField=array('urlold','url');
  $ArrValue=array($fileName, $ImageUrl.$s_filename);

  $MyDatabase=new Database();

  $MyDatabase->Insert('article_pic', $ArrField, $ArrValue);

  return $s_filename;
}

/**
 * 保存本地图片文件，并是否打水印
 * @param $fileName   文件名        没有默认值，必须指定
 * @param $ImagePath  保存路径      没有默认值
 * @param $ext_name   后缀名        没有默认值
 * @param $watermark  是否打水印    默认值为1，打水印
 *
 * @return 文件路径
 */
function savePicLocal($fileName ,$ImagePath, $ext_name, $watermark=0){
  $s_filename = basename( $fileName );
  //  $ext_name = strtolower( strrchr( $s_filename, "." ) );

  //  if( ( ".jpg" && ".gif" && ".png" && ".bmp" ) != strtolower( $ext_name ) )  {
  //    return "";
  //  }

  /*
   if( 0 == strpos( $fileName, "/" ) )
   {
   //    preg_match( "@http://(.*?)/@i", $this->URL, $url );
   $url = $url[0];
   }
   //*/

  //  $contents = file_get_contents( $url . $fileName );
  $contents = file_get_contents( $fileName );
  $s_filename = date( "His", time() ) . rand( 1000, 9999 ) . $ext_name;

  //file_put_contents( $this->saveImagePath.$s_filename, $contents );

  $handle = fopen ( $ImagePath.$s_filename, "w" );
  fwrite( $handle, $contents );
  fclose($handle);

  if ($watermark==1)   {
    imageWaterMark($ImagePath.$s_filename, 9, WATERMARKPIC);
    //imageWaterMark($ImagePath.$s_filename,9,"","http://www.zerolone.com/",5,"#FF0000");
  }

  return $s_filename;
}

/**
 * 计算一个全部都是数字的字符串总值，验证用
 *
 * @param $string 字符串
 * @return 数值
 */
function count_string($string){
  $string_len=strlen($string);
  $count=0;
  for($i=0;$i<$string_len;$i++)  {
    $count+=substr($string, $i, 1);
  }
  return $count;
}

/**
 * 远程抓取图片，保存到本地服务器
 * @param  $content  需要转换的内容
 * @return 返回图片替换后的数据
 */
function getContent($Content){
  $Content  = stripslashes($Content);
  //  echo $Content;

  //获取图片路径
  //  preg_match_all( " <img[^>]*src=[\"|']?(^>+)[\"|']?[^>]*>", $Content, $temp );
  //  preg_match_all( "/src=(\"|')(.*?)(\"|')/i", DeCodeStr($Content), $temp );
  preg_match_all( "/src=(\"|')(.*?)(\"|')/i", $Content, $temp );
  $imageList = $temp[2];

  //  echo '<hr>'. print_r($imageList) . '<hr>';
  //*/

  $ImagePath = date("ym",time()) . '/'. date("d",time());
  createFolder(IMAGEPATH, $ImagePath);

  //网页上面的路径
  $ImageUrl      =IMAGEURL. $ImagePath;

  for ( $i = 0; $i < count( $imageList ); $i++ )  {
    $fName = saveFile( $imageList[$i], $ImagePath, $ImageUrl);
    if( !empty( $fName ) )    {
      $filename[$i] = $fName;
    }
  }

  for ( $i = 0; $i < count( $imageList ); $i++ )  {
    $Content = str_replace( $imageList[$i], $ImageUrl.$filename[$i], $Content );
  }

  /*
   echo '<hr>';
   echo $Content;
   echo '<hr>';
   exit();
   //*/

  /*
   //去掉无用的页面脚本
   //去掉js
   $cp = preg_replace( "@\<script(.*?)\</script\>@is", "", $cp );

   //去掉HTML
   //去Table
   $cp = preg_replace( "@\<table(.*?)\</table\>@is", "", $cp );
   //去Tr
   $cp = preg_replace( "@\<tr(.*?)\</tr\>@is", "", $cp );
   //去Td
   $cp = preg_replace( "@\<td(.*?)\</td\>@is", "", $cp );
   //去div
   $cp = preg_replace( "@\<div(.*?)\</div\>@is", "", $cp );

   //去iframe
   $cp = preg_replace( "@\<iframe(.*?)\</iframe\>@is", "", $cp );

   //去掉css
   //$cp = preg_replace( "@\<style(.*?)\</style\>@is", "", $cp );
   */

  //去掉超连接
  $Content = preg_replace( EnCodeStr("@\<a(.*?)\>@is"), "", $Content );

  //去<!-- -->
  $Content = preg_replace( EnCodeStr("@\<!--(.*?)\--\>@is"), "", $Content );
  return $Content;
}

/**
 * 删除文件
 *
 * @param Filename 文件名， 物理路径 字符串
 */
function deleteFile($Filename){
  if(file_exists($Filename)) unlink($Filename);
}

/**
 * 循环遍历生成文件夹
 * @param $baseFolder  基础文件夹，这个文件夹必须存在，省的重复判断
 * @param $Folder      需要生成的文件夹
 * @param $Cut         最后一个不需要生成， 这个用在文件生成用的
 */
function createFolder($baseFolder, $Folder, $Cut=0){
  $boolReturn = true;
  if(!file_exists($baseFolder.$Folder))  {
    //创建文件夹
    $Folder_Str = '';
    $Folder_Arr = explode('/', $Folder);
    $Folder_Len = count($Folder_Arr) - $Cut; 
    for ($i=0; $i<$Folder_Len; $i++){
      if ($Folder_Arr[$i] != ''){
        $Folder_Str.='/'.$Folder_Arr[$i];
        //如果存在，就不用再生成
        if(!file_exists($baseFolder . '/' . $Folder_Str)){
          if (!mkdir($baseFolder . '/' . $Folder_Str, 0777)){
          //if (!mkdir($baseFolder . '/' . $Folder_Str)){
            $boolReturn = false;
          }
        }
      }
    }
  }
  return $boolReturn;
}

/**
 * 将模块数转换成一个字符串
 * @param TheString 字符串
 * @param Filename 文件名， 物理路径 字符串
 * @return
 */
function tostr($TheString){
  $TheString      = decbin($TheString);
  $TheString_len  = strlen($TheString);
  $TheString_num  = 32;

  for($i=0;$i<$TheString_num-$TheString_len;$i++)
  $TheString= '0'.$TheString;
  return($TheString);
}

/**
 * 根据编号，显示选定值
 * @param  $order 选定的顺序,默认为0
 * @return  字符串
 */
function getOrderList($order=0){
  $RetrunStr='';

  unset($order_list);
  //列表
  for ($i=1;$i<=99;$i++){
    $RetrunStr.='<option value="'.$i . '"';
    if ($order==$i) $RetrunStr.=' selected';
    $RetrunStr.= '>' . $i . '</option>';
  }

  //如果默认的order大于循环数，则显示一个
  if ($order>$i) $RetrunStr.='<option value="'.$order . '" selected >' . $order . '</option>';

  return $RetrunStr;
}

/**
 * 后台用分页
 *
 * @param $recordcount   总记录数
 * @param $pagenum       页面记录数，默认为20
 * @param $pagesize      显示翻页数
 * @param $showrs        当前页
 * @param $maxpagelimit  最大翻页数
 *
 * @return 分页数组
 */
function SplitPage($recordcount=100, $pagenum=1, $pagesize=20, $showrs=10, $maxpagelimit=50 ){
  //返回值
  $ReturnString='';

  //总页数
  $pagecount = ceil($recordcount / $pagesize);

  //最大移动数
  $pagend  = $pagenum+$maxpagelimit;
  if($pagend > $pagecount){
    $pagend  = $pagecount;
  }

  //如果为第一页， 则第一页的上一页也是第一页
  if($pagenum==1){
    $pagenum_up  = 1;
  }else{
    $pagenum_up = $pagenum-1;
  }

  //下一页， 如果下一页大于等于当前页，则下一页也是当前页
  $pagenum_down  = $pagenum+1;
  if ($pagenum_down > $pagecount){
    $pagenum_down  = $pagecount;
  }

  //前显记录数， 用舍余方式
  $showrs_begin  =  floor($showrs/2);

  //后显记录数，减掉前显记录数，再减掉当前记录数
  $showrs_end    =  $showrs-$showrs_begin-1;

  //起始页数
  $pagenum_begin   = $pagenum-$showrs_begin;
  if ($pagenum_begin<=1){
    $pagenum_begin=1;
  }

  //结束页数
  $pagenum_end    = $pagenum+$showrs_end;
  if ($pagenum_end>$pagecount){
    $pagenum_end=$pagecount;
  }

  //如果翻页数小于$showrs，则补全， 除非总的记录数小于$showrs
  $cutrs = $showrs-($pagenum_end-$pagenum_begin+1);
  if ($cutrs>0){
    if (($pagenum_begin-$cutrs)>0){
      $pagenum_begin=$pagenum_begin-$cutrs;
    }else{
      $pagenum_begin=1;
      $pagenum_end=$showrs;
      if ($pagenum_end>=$pagecount){
        $pagenum_end=$pagecount;
      }
    }
  }

  //第一页
  $ReturnString='<a href="javascript:goto(\'1\');" title="第一页"><b>|&lt;</b></a>  ';

  //上一页
  $ReturnString.='<a href="javascript:goto(\''. $pagenum_up .'\');" title="上一页"><b>&lt;</b></a>  ';

  for ($i=$pagenum_begin;$i<=$pagenum_end;$i++){
    if ($i==$pagenum){
      $ReturnString.='[<font color="red">'.$i.'</font>] ';
    }else{
      $ReturnString.='[<a href="javascript:goto(\''.$i.'\');" title="第'.$i.'页">'.$i.'</a>] ';
    }
  }

  $ReturnString.='<a href="javascript:goto(\''.$pagenum_down.'\');" title="下一页"><b>&gt;</b></a> ';
  $ReturnString.='<a href="javascript:goto(\''.$pagend.'\');" title="第'.$pagend.'页"><b>&gt;|</b></a> ';
  $ReturnString.='<strong><font color=red>'.$pagenum.'</font>/'.$pagecount.'</strong>页&nbsp;';
  $ReturnString.='<b><font color="#FF0000">'.$recordcount.'</font></b>条记录&nbsp;<b>'.$pagesize.'</b>条/页&nbsp;';
  $ReturnString.='转到：<input type="text" name="pagenum" id="pagenum" size=2 maxlength=10 class="InputBox" value="'.$pagenum.'"> <input class="inputbox" type="submit"  value="Go"  name="cndok">';

  return $ReturnString;
}

/**
 * 获取上一级页面提交的参数
 *
 * @param $value   需要获取的参数
 * @param $default 默认返回值
 *
 * @return   获取的参数值
 */
function Request($value, $default='') {
  if (isset ( $_POST [$value] )) {
    return $_POST [$value];
  } elseif (isset ( $_GET [$value] )) {
    return $_GET [$value];
  } else {
    return $default;
  }
}

/**
 * 错误信息
 *
 * @param 错误内容 $msg
 * @param 返回地址 $url
 */
function ErrorMsg($refresh_msg='',$refresh_url=''){
  //获取来源页面
  if($refresh_url=='') $refresh_url=@$_SERVER['HTTP_REFERER'];
  if($refresh_url=='') $refresh_url=SITE_URL;
  require 'include/refresh.php.php';
  exit();
}

/**
 * 格式化日期
 *
 * @param 时间
 * @param 时间格式，默认为Y-m-d H:i:s
 */
function get_date($timestamp, $timeformat='Y-m-d H:i:s'){
  if ($timestamp>=0) return date($timeformat,$timestamp);
}

/**
 * 打印数组，也是为了调试信息用
 *
 * @param Array $TheArray
 * @return Array
 */
function print_array($TheArray) {
  $TmpStr = '';
  $TmpStr .= "Array\n{\n";
  if (isset ( $TheArray )) {
    foreach ( $TheArray as $Key => $value ) {
      @$TmpStr .= '    [' . $Key . ']  => ' . $value . "\n";
    }
  }
  $TmpStr .= "}\n";
  return $TmpStr;
}

/**
 * 打印字符串，用<hr>包含
 *
 * @param 字符串 $str
 */
function DebugStr($str=''){
  if(SHOW_DEBUG==1) {
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    if($str<>'') echo '<hr color=blue>'.$str;
    echo '<hr color=blue>';
  };
}

function DDDebugStr($str=''){
  if(SHOW_DEBUG==1 && @$_GET['ddd']=='ddd') {
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    if($str<>'') echo '<hr color=blue>'.$str;
    echo '<hr color=blue>';
  };
}

function vvar_dump($str){
  if(SHOW_DEBUG==1){
   echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
   var_dump($str);
  }
}


function vvvar_dump($str){
  if(SHOW_DEBUG==1 && @$_GET['ddd']=='ddd') {
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    var_dump($str);
  }
}

function eexit(){
  if(SHOW_DEBUG==1) exit();
}

function eeexit(){
  if(SHOW_DEBUG==1 && @$_GET['ddd']=='ddd') exit();
}

/**
 * 打印数组， 用<hr>包含
 * @param $arr 需要打印的数组
 */
function DebugArr($arr){
  if(SHOW_DEBUG==1) var_dump($arr);
}

/**
 * 弹出一个提示
 * @param $str 提示内容
 */
function DebugAlert($str){
  echo '<script>alert("' . $str . '")</script>';
}

function DebugJS($str){
  echo '<script>'.$str.'</script>';
}


/**
 * 根据编号，显示选定值
 * @param   $aid 选定的顺序,默认为0
 * @return  字符串
 */
function getAreaList($areaArr, $aid=0){
  $RetrunStr='';
  foreach($areaArr as $id => $area){
    $RetrunStr.='<option value="'.$id . '"';
    if ($aid==$id) $RetrunStr.=' selected';
    $RetrunStr.= '>' . $area . '</option>';
  }
  return $RetrunStr;
}

/**
 * 根据编号，显示选定省
 * @param   $prov 选定的顺序,默认为0
 * @return  字符串
 */
function getProvList($provArr, $pid=0){
  $RetrunStr='';
  foreach($provArr as $id => $prov){
    $RetrunStr.='<option value="'.$id . '"';
    if ($pid==$id) $RetrunStr.=' selected';
    $RetrunStr.= '>' . $prov . '</option>';
  }
  return $RetrunStr;
}

/*
 * 替换回复内容，保留br
 */
function replaceFeedbackContent($str=''){
  $str   = str_replace('就诊方式：','',      $str);
  $str   = str_replace('看病过程：','',      $str);
  $str   = str_replace('好大夫在线','名医汇',$str);
  $str   = str_replace('好大夫网站','名医汇',$str);
  $str   = strip_tags($str, '<br>');  
  return $str;
}

/*
* rc4加密算法
* $data 要加密的数据
*/
function rc4 ($data){
  $pwd = SALT.SALT;  //2把盐
  $key[] ="";
  $box[] ="";
  $cipher = '';
  
  $pwd_length = strlen($pwd);
  $data_length = strlen($data);
  
  for ($i = 0; $i < 111; $i++) {
    $key[$i] = ord($pwd[$i % $pwd_length]);
    $box[$i] = $i;
  }
  
  for ($j = $i = 0; $i < 111; $i++){
    $j = ($j + $box[$i] + $key[$i]) % 111;
    $tmp = $box[$i];
    $box[$i] = $box[$j];
    $box[$j] = $tmp;
  }
  
  for ($a = $j = $i = 0; $i < $data_length; $i++){
    $a = ($a + 1) % 111;
    $j = ($j + $box[$a]) % 111;
    
    $tmp = $box[$a];
    $box[$a] = $box[$j];
    $box[$j] = $tmp;
    
    $k = $box[(($box[$a] + $box[$j]) % 111)];
    $cipher .= chr(ord($data[$i]) ^ $k);
  }
  return $cipher;
}

//简单判断前3位是不是被rc4了
function isrc4($str){
  $boolReturn = false;
  $num1 = substr($str,0,1);
  $num2 = substr($str,1,1);
  $num3 = substr($str,2,1);
  if(is_numeric($num1) && is_numeric($num1) && is_numeric($num3)){
  }else{
    $boolReturn = true;
  }
  return $boolReturn;
}

/**
 * 获得当前格林威治时间的时间戳
 *
 * @return  integer
 */
function gmtime(){
  return (time() - date('Z'));
}

/**
 * 手机验证是否合法
 * 
 * @param   string      $email      需要验证的手机号
 * 
 * @return bool
 */
function is_telephone($phone){
  $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/";
  if (preg_match($chars, $phone)){
    return true;
  }
}

/**
 * 验证输入的邮件地址是否合法
 *
 * @access  public
 * @param   string      $email      需要验证的邮件地址
 *
 * @return bool
 */
function is_email($user_email){
  $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
  if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false){
    if (preg_match($chars, $user_email)){
      return true;
    }else{
      return false;
    }
  }else{
    return false;
  }
}

/*
 * curl，通用方法 
 * @param urlVisit   访问地址
 * @param CookieFile Cookie文件
 * @param params     提交内容， 有这个则为post方式
 * @param urlRefer   refer

 * @return 抓取到的原始内容
 */
function curlGet($urlVisit, $CookieFile='', $params='', $urlRefer=''){
  if($urlRefer==''){
    $urlRefer=$urlVisit;
  }
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_REFERER,        $urlRefer);
  curl_setopt($ch, CURLOPT_URL,            $urlVisit);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)');
  
  if($params!=''){
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
  }
  
  if($CookieFile!=''){
    curl_setopt($ch, CURLOPT_COOKIEJAR,  $CookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $CookieFile);
  }
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  $c = curl_exec($ch);// 执行操作
  curl_close($ch);
  
  return $c;
}


/*
 * 判断是否登录
 */
function checkLogin(){
  $isLogin = 0;
  if (isset ( $_SESSION [SALT.'login'] )) {
    $isLogin = $_SESSION [SALT.'login'];
  }
  
  if ($isLogin != 1) {
    $page_name = 'include/refresh.php'; 
    
    $refresh_msg = '你尚未登陆或登录超时，请重新登录。';
    $refresh_url = 'login.php';
    
    require ($page_name . '.php');
    die();
  }
}

/*
 * 判断权限
 */
function checkPermission($permission){
  if($permission>0)$permission = -$permission;
  if(substr($_SESSION[SALT.'permission'], $permission, 1)==1){
    return true;
  }
}

/**
 * 获取客户端IP
 */
function getIP() {
  if (getenv ( "HTTP_CLIENT_IP" ) && strcasecmp ( getenv ( "HTTP_CLIENT_IP" ), "unknown" ))
    $ip = getenv ( "HTTP_CLIENT_IP" );
  else if (getenv ( "HTTP_X_FORWARDED_FOR" ) && strcasecmp ( getenv ( "HTTP_X_FORWARDED_FOR" ), "unknown" ))
    $ip = getenv ( "HTTP_X_FORWARDED_FOR" );
  else if (getenv ( "REMOTE_ADDR" ) && strcasecmp ( getenv ( "REMOTE_ADDR" ), "unknown" ))
    $ip = getenv ( "REMOTE_ADDR" );
  else if (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], "unknown" ))
    $ip = $_SERVER ['REMOTE_ADDR'];
  else
    $ip = "unknown";
  return ($ip);
}

?>