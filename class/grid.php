<?php
/**
 * 后台专用表格自动生成类
 * 
 * @version 2015-8-31 20:43:48
 * @author  Zerolone
 * 
 */

class Grid{
  public  $title;             //表单头
  public  $action;            //提交的页面
  public  $method  = 'POST';  //提交方式
  private $enctype = '';
  public  $name    = '';
  public  $id      = '';
  public  $css     = '';
  public  $target  = '';
  
  public $thead    = array(); //表格头
  public $arrItems = array(); //表格控件数组
  
  private $page = 1;      //当前页
  private $pagecount = 1; //总页数
  private $pagesize = 10; //分页数
  
  
  //控件用
  private $columns = array();
  private $recordcount = 0;
  
  public $js;      //最后执行的js， 比jquery还后面的


  /**
   * 通过构造函数初始化成员变量
   */
  public function __construct($title='', $name=''){
    $this->title = $title;
    $this->name  = $name;
    
    $rndFrom = 'from'.$_SERVER['REQUEST_TIME'].rand(10000,999999);
    
    if($this->name =='') $this->name = $rndFrom;
    if($this->id ==''  ) $this->id   = $rndFrom;
  }
    
  /**
   * 表单头
   */
  private function head(){
    $strTmp = '<div class="table-responsive"><form name="'.$this->name.'" id="'.$this->id.'"><table class="table table-striped table-hover">';
    $strTmp.= '
      <caption>'.$this->title.'</caption>
    ';
    return $strTmp;
  }
  
  /**
   * 表单尾
   */
  public function foot(){
    $strTmp = '</tbody></table></form></div>
    ';
    return $strTmp;
  }
  
  /**
   * 生成表单
   */
  public function create(){
    $this->getContent();
    $strTrs = $this->items();
  
    $strTHead = '
      <thead>
         <tr>
    ';
    foreach($this->thead as $th){
      $strTHead.='<th>'.$th.'</th>';
    }
    $strTHead.='</tr>
      </thead>
      <tbody>
    ';
    
    $strTmp = $this->head() . $strTHead . $strTrs . $this->page() . $this->foot();
    
    
    
    
    return $strTmp;
  }
  
  /**
   * 创建表格内容
   */
  public function items(){
    $tmpVal = '';
    $i      = 0;
    
    foreach($this->columns as $item){
      $tmpVal.= '<tr>';
      foreach($item as $key => $val){
        if($i==0){
          $this->thead[] = $key;
        }
        $tmpVal.= '<td>'.$val.'</td>';
      }
      $i = 1;
      $tmpVal.= '</tr>';
    }
    
    return $tmpVal;
  }
  
  /**
   * 表格内容
   * 
   * @params params 参数列表
   *
   */
  private function getContent(){
    $MyDatabase = Database::Get();
    
    $Table      = '`'.DB_TABLE_PRE.$this->params['table']. '`';
    $SqlWhere   = @$this->params['where'];
    $SqlOrderBy = @$this->params['order']; if($SqlOrderBy<>'') $SqlOrderBy = 'ORDER BY '.$SqlOrderBy;
    $SqlLimit   = ' LIMIT '. ($this->params['page']-1) * $this->params['pagesize'] .' ,'.$this->params['pagesize'].';';
    
    $SqlStr  = ' SELECT COUNT( * ) FROM '.$Table;
    $SqlStr.= $SqlWhere;
    $MyDatabase->SqlStr=$SqlStr;
    if ($MyDatabase->Query ()) $this->recordcount = $MyDatabase->ResultArr [0][0];
    
    $SqlStr = 'SELECT '.$this->params['column'].' FROM '.$Table;
    $SqlStr.= $SqlWhere;
    $SqlStr.= $SqlOrderBy;
    $SqlStr.= $SqlLimit;
    $MyDatabase->SqlStr=$SqlStr;
    DebugStr($SqlStr);
    if ($MyDatabase->Query2 ()){
      $this->columns = $MyDatabase->ResultArr;
    }
    
    //分页用
    $this->page      = $this->params['page'];
    $this->pagesize  = $this->params['pagesize'];
  }
  
  /**
    * 分页
    * 
    * 
    */
  private function page(){
    $tmpStr = '<tr><td colspan=999>'.SplitPage($this->recordcount, $this->page, $this->pagesize).'</td></tr>';

        $this->js.= '
        <script language="javascript">
          function goto(pagenum){
            $("#pagenum").val(pagenum);
            $("#'.$this->name.'").submit();
          }
        </script>
        ';

    return $tmpStr;
  }


  
  
  
////////////////////////////////////
}