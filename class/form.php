<?php
/**
 * 后台专用表单自动生成类，目前不支持别名
 * 
 * @version 2015-8-24 22:25:55
 * @author  Zerolone
 * 
 */

class Form{
  public  $title;             //表单头
  public  $action;            //提交的页面
  public  $method  = 'POST';  //提交方式
  private $enctype = '';
  public  $name    = '';
  public  $id      = '';
  public  $css     = '';
  public  $target  = '';
  
  private $arrItems    = array(); //表单控件数组
  
  //控件用
  private $item;
  private $names = array();
  private $version = array(
    'umeditor'  => '1.2.2', 'umeditor.min'  => '',  // .min
    'Validform' => '5.3.2', 'Validform.min' => '',  // _min
    
  );
  
  public $js;  //最后执行的js， 比jquery还后面的
  
  /**
   * 通过构造函数初始化成员变量
   */
  public function __construct($title='', $action='', $target=''){
    $this->target = $target;
    $this->action = $action;

    $this->title = $title;
    if($title=='') $this->title = '请填写表单';
  
    $rndFrom = 'from'.$_SERVER['REQUEST_TIME'].rand(10000,999999);
    
    $enctype = '';
    if($this->name =='') $this->name = $rndFrom;
    if($this->id ==''  ) $this->id   = $rndFrom;
    
    //vaildform
    //      <script type="text/javascript">$("#'.$this->id.'").Validform({tiptype:3});</script>
    $this->js = '
      <link href="lib/Validform/css/style.css" type="text/css" rel="stylesheet">
      <script type="text/javascript" charset="utf-8" src="lib/Validform/js/Validform_v'.$this->version['Validform'].$this->version['Validform.min'].'.js"></script>
      <script type="text/javascript">$("#'.$this->id.'").Validform();</script>
    ';
  }
    
  /**
   * 表单头
   */
  private function head(){
    $arrFormHead = array(
      'name'    => $this->name,
      'id'      => $this->id,
      'css'     => $this->css,
      'action'  => $this->action,
      'method'  => $this->method,
      'enctype' => $this->enctype,
      'target'  => $this->target,
    );

    $strTmp = '<div class="container"><form class="form-horizontal" ';
    foreach($arrFormHead as $param => $value){
      if($value!='') $strTmp.= $param.'="'.$value.'" ';
    }
    $strTmp.='>';
    $strTmp.='<fieldset><legend>'.$this->title.'</legend>';
    return $strTmp;
  }

  /**
   * 表单尾
   */
  public function foot(){
    $strTmp = '</fieldset></form></div>';
    return $strTmp;
  }
  
  /**
   * 生成表单
   */
  public function create(){
    $strItem = '';
    foreach ($this->arrItems as $item) $strItem.=$item;
    $strTmp = $this->head() . $strItem . $this->foot();
    return $strTmp;
  }
  
  /**
   * 得到设置值，没有的话，就得到默认值
   * 
   * @param val         是否存在的val
   * @param defaultVal  默认val
   */
  private function itemVal($key, $defaultVal=''){
    $tmpVal = $defaultVal;
    if(isset($this->item[$key])){
      $tmpVal = $this->item[$key];
    }
    return $tmpVal;
  }
  
  /**
   * 创建一个控件、组
   */
  public function item($itemArr){
    $tmpStr = '<div class="form-group">';
    foreach($itemArr as $i){
      $this->item = $i;
      $tmpStr.= $this->itemBuild();
    }
    $tmpStr.='</div>';
    $this->arrItems[] = $tmpStr;
  }
  
  /**
   * 生成一个控件字符串
  name -------- 名， 必填字段
  id ---------- id
  label ------- 标签
  labelWidth -- 标签长度
  value ------- 内容
  type -------- 类型 
    ----html自带的控件--
    
    text ------ 文本框 ===== txt
    password -- 密码框 ===== pwd\pass
    file ------ 文件上传框 = upload\upfile\up
    radio ----- 单选框 ===== 
    checkbox -- 多选框 ===== check
    select ---- 下拉选择 === option  通过参数 multiple 可以使用多选或者单选 
    textarea -- 文本框 ===== 
    hidden ---- 隐藏域 =====
    submit ---- 提交按钮 ===
    button ---- 普通按钮 ===
    
    ----增强控件----
    richedit -- 富文本编辑器 == content/richeditor/rich/editor/umeditor/ueditor， 这里使用的是baidu的umeditor

   */
  function itemBuild(){
    $name        = $this->itemVal('name'); if($name=='') die('name unset !');
    
    if(in_array($name, $this->names)){
      die('name ['.$name.'] duplicate !');
    }else{
      $this->names[] = $name;
    }
    
    $id          = $this->itemVal('id',   $name);
    $width       = $this->itemVal('width', 12) + 0;
    $type        = $this->itemVal('type', 'text');
    $label       = $this->itemVal('label');
    $labelWidth  = $this->itemVal('labelWidth');
    $value       = $this->itemVal('value');
    $placeholder = $this->itemVal('placeholder',   $label);
    
    //select、checkbox专用
    $options     = $this->itemVal('options');
    $multiple    = $this->itemVal('multiple');
    $inline      = $this->itemVal('inline');
    
    //button专用
    $style       = $this->itemVal('style', 'default');
    
    //自定义宽度，高度
    $eWidth      = $this->itemVal('eWidth')  + 0;
    $eHeight     = $this->itemVal('eHeight') + 0;
    
    //验证用
    $datatype    = $this->itemVal('datatype');
    $errormsg    = $this->itemVal('errormsg');
    $strValid    = '';
    if($datatype!='') $strValid = ' datatype="'.$datatype.'" errormsg="'.$errormsg.'"';
    
    $tmpStr = '';
    if($label!='')$label.=':';
    if($labelWidth>0) $tmpStr.= '<label class="col-sm-'.$labelWidth.' control-label" for="'.$name.'">'.$label.'</label>';
    $tmpStr.= '<div class="col-sm-'.$width.'">';
    switch ($type) {
      case 'text':
      case 'password':
      case 'file':
        $tmpStr.= '<input class="form-control" type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'" placeholder="'.$placeholder.'" '.$strValid.' />';
        break;
      case 'radio':
      case 'checkbox':
        foreach($options as $o){
          $checked = @$o['checked'];
          $tmpStr.='<label class="'.$type.$inline.'">';
          $tmpStr.='<input name="'.$name.'" type="'.$type.'" value="'.$o['val'].'" '.$checked.'>'.$o['text'];
          $tmpStr.='</label>';
        }
        break;
      case 'select':
        $tmpStr.= '<select class="form-control" name="'.$name.'" id="'.$id.'" '.$multiple.'>';
        foreach($options as $o){
          $selected = @$o['selected'];
          $tmpStr.='<option value="'.$o['val'].'" '.$selected.'>'.$o['text'].'</option>';
        }
        $tmpStr.= '</select>';
        
        break;
      case 'textarea':
        $tmpStr.= '<textarea class="form-control" name="'.$name.'" id="'.$id.'">'.$value.'</textarea>';
        
        break;
      case 'hidden':
        $tmpStr = '<div style="display:hidden">';  //注意这里， 不是.=
        $tmpStr.= '<input class="form-control" type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'" />';
        break;
      case 'submit':
      case 'button':
        $tmpStr.= '<button type="'.$type.'" class="btn btn-'.$style.'" name="'.$name.'" id="'.$id.'" value="'.$value.'">'.$value.'</button>';
        break;
      case 'richedit':
        $eWidth  > 100 ? $eWidth.='px'  : $eWidth.='%';
        $eHeight > 100 ? $eHeight.='px' : $eHeight.='%';
        
        $tmpStr.= '<script type="text/plain" id="'.$id.'" style="width:'.$eWidth.';height:'.$eHeight.';">'.$value.'</script>';
        $this->js.= '
          <link href="lib/umeditor'.$this->version['umeditor'].'/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
          <script type="text/javascript" charset="utf-8" src="lib/umeditor'.$this->version['umeditor'].'/umeditor.config.js"></script>
          <script type="text/javascript" charset="utf-8" src="lib/umeditor'.$this->version['umeditor'].'/umeditor'.$this->version['umeditor.min'].'.js"></script>
          <script type="text/javascript" src="lib/umeditor'.$this->version['umeditor'].'/lang/zh-cn/zh-cn.js"></script>
          <script type="text/javascript">
              var um = UM.getEditor("'.$id.'");
          </script>
        ';
        
        break;
      default:
        die('wrong type:'.$type);
    }
    
    //二次定制处理
    switch ($type) {
      case 'file':
        $this->enctype    = "multipart/form-data";
        break;
    }
    
    $tmpStr.='</div>'."\n";
    return $tmpStr;
  
  }
  
////////////////////////////////////
}