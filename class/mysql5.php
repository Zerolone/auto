<?php
/**
 * MySQL数据库调用类，仅支持PHP5
 * 采用单件模式，调用方式为： $MyDatabase=Database::Get();
 * @version 2015-7-27 19:14:59
 * @author  Zerolone
 */

class Database {
  protected $ResID;          //连接标识

  public $SqlStr      = '';  //查询语句
  public $ResultArr   = '';  //返回数组
  public $QueryCount  = 0;   //查询次数
  public $QueryStr    = '';  //查询语句
  public $RecordCount = 0;   //总记录数
  public $PageNum     = 1;   //页数
  public $PageSize    = 16;  //分页数
  public $Thispage    = '';  //当前页

  /**
   * 从这里创建这个类
   */
  public static function Get(){
    static $TheDatabase=null;
    if($TheDatabase==null) $TheDatabase=new Database();
    return $TheDatabase;
  }

  /**
   * 连接数据库
   */
  private function __construct() {
      //建立数据链接
    if(!($this->ResID = mysql_connect(DB_HOST.':'.DB_PORT, DB_USER, DB_PASS))) {
      $this->error_alert ('Database Error', DB_HOST, 'Connect Server Error');
    }else{
      //选择数据库
      if (!mysql_select_db (DB_NAME, $this->ResID)) {
        $this->error_alert ('Database Error', DB_NAME, 'Database Not Found');
      }
    }

    //判断MySQL的版本信息
    if (version_compare($this->version(), '5.0', '<')) {
      die('MySQL Need 5.0 Or Higher, Your Version:' . $this->version () . ", Please Update MySQL");
    }

    //指定数据库编码，避免字符出错。
    mysql_query ('SET NAMES "' . DB_LANG . '"');
  }

  /**
   * 断开链接
   *
   */
  public function __destruct() {
    //MysqlServer会在脚本执行完毕后自动关闭，所以不用
    //mysql_close($this->ResID);
  }

  /**
   * 添加一条记录
   * @param TableName 表名     无默认值，不需要加表前缀，在/include/config.inc.php文件中已经指定
   * @param ArrField  字段数组 无默认值
   * @param ArrValue  数据数组 无默认值
   *
   * @return 0或者1， 0 为失败， 1为成功
   */
  public function Insert($TableName, $ArrField, $ArrValue) {
    $SqlL = 'INSERT INTO `' . DB_TABLE_PRE . $TableName . '` (';
    $SqlR = 'VALUES (';
    
    //数组长度
    $CountArr = count ($ArrField);
    
    for($i = 0; $i < $CountArr - 1; $i ++) {
      $SqlL .= '`'  . $ArrField [$i] . '`,';
      $SqlR .= '\'' . $ArrValue [$i] . '\',';
    }
    
    $SqlL .= '`'  . $ArrField [$i] . '`)';
    $SqlR .= '\'' . $ArrValue [$i] . '\');';
    
    //记录
    $this->QueryCount ++;
    $this->QueryStr .= '#' . $this->QueryCount . "\n";
    $this->QueryStr .= $SqlL . $SqlR . "\n";
    
    $this->SqlStr= $SqlL . $SqlR ;
    
    return mysql_query($SqlL . $SqlR);
  }
  
  /**
   * 添加一条记录或者更新一条记录
   * @param TableName 表名     无默认值，不需要加表前缀，在/include/config.inc.php文件中已经指定
   * @param ArrField  字段数组 无默认值
   * @param ArrValue  数据数组 无默认值
   * @param UPDATE    如果存在， 更新的字符串   无默认值
   *
   * @return 0或者1， 0 为失败， 1为成功
   */
  public function InsertOrUpdate($TableName, $ArrField, $ArrValue, $StrUpdate) {
    $SqlL = 'INSERT INTO `' . DB_TABLE_PRE . $TableName . '` (';
    $SqlR = 'VALUES (';
    
    //数组长度
    $CountArr = count ($ArrField);
    
    for($i = 0; $i < $CountArr - 1; $i ++) {
      $SqlL .= '`'  . $ArrField [$i] . '`,';
      $SqlR .= '\'' . $ArrValue [$i] . '\',';
    }
    
    $SqlL .= '`'  . $ArrField [$i] . '`)';
    $SqlR .= '\'' . $ArrValue [$i] . '\')';
    
    $SqlR.= ' ON DUPLICATE KEY UPDATE'.$StrUpdate.';';
    
    //记录
    $this->QueryCount ++;
    $this->QueryStr .= '#' . $this->QueryCount . "\n";
    $this->QueryStr .= $SqlL . $SqlR . "\n";
    
    $this->SqlStr= $SqlL . $SqlR ;
    
    return mysql_query($SqlL . $SqlR);
  }
  
  /**
   * 添加一条记录或者更新一条记录2
   * @param TableName 表名     无默认值，不需要加表前缀，在/include/config.inc.php文件中已经指定
   * @param ArrField  字段数组 无默认值
   * @param ArrValue  数据数组 无默认值
   *
   * @return 0-失败， 1-成功
   */
  public function InsertOrUpdate2($TableName, $ArrField, $ArrValue) {
    $SqlL = 'INSERT INTO `' . DB_TABLE_PRE . $TableName . '` (';
    $SqlR = 'VALUES (';
    
    //数组长度
    $CountArr = count ($ArrField);
    
    for($i = 0; $i < $CountArr - 1; $i ++) {
      $SqlL .= '`'  . $ArrField [$i] . '`,';
      $SqlR .= '\'' . $ArrValue [$i] . '\',';
    }
    
    $SqlL .= '`'  . $ArrField [$i] . '`)';
    $SqlR .= '\'' . $ArrValue [$i] . '\')';
    
    //提交重复后更新
    $SqlR.= ' ON DUPLICATE KEY UPDATE ';
    for($i = 0; $i < $CountArr - 1; $i ++) {
      $SqlR .= '`'  . $ArrField [$i] . '`=';
      $SqlR .= '\'' . $ArrValue [$i] . '\',';
    }
    
    $SqlR .= '`'  . $ArrField [$i] . '`=';
    $SqlR .= '\'' . $ArrValue [$i] . '\'';
    $SqlR .= ';';
    
    //记录
    $this->QueryCount ++;
    $this->QueryStr .= '#' . $this->QueryCount . "\n";
    $this->QueryStr .= $SqlL . $SqlR . "\n";
    
    $this->SqlStr= $SqlL . $SqlR ;
    
    return mysql_query($SqlL . $SqlR);
  }

  /**
   * 获取最后插入的id编号，需要有AUTO_INCREMENT 的 ID，支持int，bigint听说是要LAST_INSERT_ID()
   *
   * @return id
   */
  public function Insert_id() {
    return mysql_insert_id ($this->ResID);
  }

  /**
   * 修改一条或多条记录
   * @param TableName 表名     无默认值，不需要写前缀
   * @param ArrField  字段数组 无默认值
   * @param ArrValue  数据数组 无默认值
   * @param WhereStr  条件语句 无默认值
   *
   * @return 0或者1， 0 为失败， 1为成功
   */
  public function Update($TableName, $ArrField, $ArrValue, $WhereStr='') {
    $SqlL = 'UPDATE `' . DB_TABLE_PRE . $TableName . '` SET ';
    
    //数组长度
    $CountArr = count ($ArrField);
    
    for($i = 0; $i < $CountArr - 1; $i ++) {
      $SqlL .= '`'  . $ArrField [$i] . '`=';
      $SqlL .= '\'' . $ArrValue [$i] . '\',';
    }
    
    $SqlL .= '`'  . $ArrField [$i] . '`=';
    $SqlL .= '\'' . $ArrValue [$i] . '\'';
    //WHERE语句
    if($WhereStr <> '') $SqlL .= ' WHERE ' . $WhereStr . ';';
    
    //记录
    $this->QueryCount ++;
    $this->QueryStr .= '#' . $this->QueryCount . "\n";
    $this->QueryStr .= $SqlL . "\n";
    
    $this->SqlStr=$SqlL;
    
    mysql_query ($SqlL);
    
    return mysql_affected_rows();
  }

  /**
   * 删除一条或多条记录
   * @param TableName 表名     无默认值
   * @param WhereStr  条件语句 无默认值
   *
   * @return 0或者1， 0 为失败， 1为成功
   */
  public function Delete($TableName, $WhereStr) {
    $SqlL = 'DELETE FROM `' . DB_TABLE_PRE . $TableName . '` WHERE ' . $WhereStr . ';';
    
    //记录
    $this->QueryCount ++;
    $this->QueryStr .= '#' . $this->QueryCount . "\n";
    $this->QueryStr .= $SqlL . "\n";
    $this->SqlStr = $SqlL;
    
    return mysql_query ($SqlL);
  }

  /**
   * 通过Sql语句查询， 返回带索引和名称的数组
   * @param SqlStr SQL语句 没有默认值，必须指定
   *
   */
  public function Query() {
    //记录
    $this->QueryCount ++;
    $this->QueryStr .= '#' . $this->QueryCount . "\n";
    $this->QueryStr .= $this->SqlStr . "\n";
    
    //查询Sql语句
    $temp_query = mysql_query($this->SqlStr, $this->ResID);

    //清空结果数组
    unset($this->ResultArr);
    $return_int=0;
    
    if(is_resource($temp_query)){ 
      //返回结果数组 
      while($row = mysql_fetch_array($temp_query)){
        //print_r($row);
        //echo '<hr>';
        $this->ResultArr[] = $row;
        $return_int=1;
      }
    }
    
   if ($return_int) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
  
  /**
   * 通过Sql语句查询， 返回数组
   * @param  SqlStr SQL语句 没有默认值，必须指定
   *
   */
  public function Query2() {
    //记录
    $this->QueryCount++;
    $this->QueryStr .= '#' . $this->QueryCount . "\n";
    $this->QueryStr .= $this->SqlStr . "\n";
    
    //查询Sql语句
    $temp_query = mysql_query($this->SqlStr, $this->ResID);
    
    //清空结果数组
    unset ($this->ResultArr);
    $return_int=0;

    if(is_resource($temp_query)){
      //返回结果数组
      while ($row = mysql_fetch_assoc ($temp_query)){
        //print_r($row);
        //echo '<hr>';
        $this->ResultArr [] = $row;
        $return_int=1;
      }
    }
    
    if ($return_int) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * 获取版本信息
   *
   * @return 版本号
   */
  public function version() {
    return mysql_get_server_info ($this->ResID);
  }

  /**
   * 执行SQL， 返回
   * @param SqlStr SQL语句 无默认值
   *
   * @return 0或者1， 0 为失败， 1为成功
   */
  public function ExecuteQuery() {
    //记录
    $this->QueryCount ++;
    $this->QueryStr .= '#' . $this->QueryCount . "\n";
    $this->QueryStr .= $this->SqlStr . "\n";
    
    //查询Sql语句
    return mysql_query ($this->SqlStr, $this->ResID);
  }
  
  /**
   * 显示调试信息
   */
  public function PrintDebug() {
    $variable_count = '查询次数：' . $this->QueryCount . '次';
    $variable_sql = $this->QueryStr . "\n";
    
    $this->Thispage=$_SERVER ['PHP_SELF'];
    
    //变量调试信息
    $variable_log = '';
    if($_GET)     $variable_log.= "本页得到的_GET变量有:" .     print_array ( $_GET );
    if($_POST)    $variable_log.= "本页得到的_POST变量有:" .    print_array ( $_POST );
    if($_COOKIE)  $variable_log.= "本页得到的_COOKIE变量有:" .  print_array ( $_COOKIE );
    if($_SESSION) $variable_log.= "本页得到的_SESSION变量有:" . print_array ( @$_SESSION );
    
    //IIS不支持， 如果出错，请注释下面一行
    //$variable_log .= "HTTP头文件:\n" . print_array ( getallheaders () );
    
    return $variable_count . $this->Thispage . ' |  [<a href="javascript:location.replace(location.href);">刷新</a>]
    <script type="text/javascript">
    function showdebug(span_show, span_source){
      var TheImg;
      span_show   = eval(span_show);
      span_source = eval(span_source)
    
      if(span_show.style.display == "none"){
        span_show.style.display = "";
        span_source.innerHTML   = "<font color=\"blue\">关闭</font>调试信息"; 
      }else{
        span_show.style.display = "none";
        span_source.innerHTML   = "<font color=\"red\">打开</font>调试信息";
      }
    }
    </script>
    <span align=left id=debug_source onClick=showdebug("debug_show","debug_source")><font color="red">打开</font>调试信息</span><br>
    <div align="left"><span id=debug_show style="display:none">
        <textarea style="width:1000;height:300" cols="100" rows="8">'.$variable_sql.$variable_log.'</textarea>
    </span>
    </div>';
  }

  /**
   * 错误提示
   * @param $ImagePath 错误类型
   * @param $ImageUrl  源
   * @param String     错误信息
   */
  function error_alert($Type, $Source, $Message) {
    $ThisPage = $_SERVER ['PHP_SELF'];
    $x = "
    Error:<font color=red>$Type</font>[<a href=\"javascript:history.go(0);\">Refresh</a>] Contact:020-8631 9776<br>
    &nbsp;Info:($Source) $Message
    <hr color=blue size=1 width=100% align=left>";
    echo $x;
  }
}

?>