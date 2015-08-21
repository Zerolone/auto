<?php
/**
 * 后台专用表单自动生成类
 * 
 * @version 2015-8-17 21:41:19
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
    if($this->id ==''  ) $this->name = $rndFrom;
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
  type -------- 类型 text, password,
  value ------- 字段值
  
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
    
    $tmpStr = '';
    if($label!='')$label.=':';
    if($labelWidth>0) $tmpStr.= '<label class="col-sm-'.$labelWidth.' control-label" for="'.$name.'">'.$label.'</label>';
    $tmpStr.= '<div class="col-sm-'.$width.'">';
    switch ($type) {
      case 'text':
      case 'password':
      case 'file':
        $tmpStr.= '<input class="form-control" type="'.$type.'" name="'.$name.'" id="'.$id.'" value="'.$value.'" placeholder="'.$placeholder.'" />';
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

    //隐藏域函数
    public function form_hidden($name, $id, $label_name, $label_for, $value = '')
    {
        $text = "<input type=\"hidden\" name=\"{$name}\" id=\"{$id}\" ";
        if (isset($value)) {
            $text .= "value=\"{$value}\" ";
        }
        $text .= '/>
';
        $label = $this->form_label($label_name, $label_for);
        $form_item = $this->form_item($label, $text);
        return $form_item;
    }
    //文件域函数
    public function form_file($name, $id, $label_name, $label_for, $size = '')
    {
        $text = "<input type=\"file\" name=\"{$name}\" ";
        $text .= "id=\"{$id}\" ";
        if (isset($size)) {
            $text .= "size=\"{$size}\" ";
        }
        $text .= '/>
';
        $label = $this->form_label($label_name, $label_for);
        $form_item = $this->form_item($label, $text);
        return $form_item;
    }
    //复选框函数
    public function form_checkbox($name, $label = array(), $label_name, $label_for = '')
    {
        $i = 0;
        $text = array();
        foreach ($label as $id => $value) {
            $text[$i] = "<input type=\"checkbox\" id=\"{$id}\" name=\"{$name}\" value=\"{$value}\" />";
            $text[$i] .= "<label for=\"{$id}\">{$value}</label>";
            $i++;
        }
        $label = $this->form_label($label_name, $label_for);
        $form_item = $this->form_item($label, $text);
        return $form_item;
    }
    //单选框函数
    public function form_radio($name, $label = array(), $label_name, $label_for = '')
    {
        $i = 0;
        $text = array();
        foreach ($label as $id => $value) {
            $text[$i] = "<input type=\"radio\" id=\"{$id}\" name=\"{$name}\" value=\"{$value}\" />";
            $text[$i] .= "<label for=\"{$id}\">{$value}</label>";
            $i++;
        }
        $label = $this->form_label($label_name, $label_for);
        $form_item = $this->form_item($label, $text);
        return $form_item;
    }
    //下拉菜单函数
    public function form_select($id, $name, $options = array(), $selected = false, $label_name, $label_for, $onchange = '')
    {
        if ($onchange !== '') {
            $text = "<select id=\"{$id}\" name=\"{$name}\" onchang=\"{$onchange}\">\n";
        } else {
            $text = "<select id=\"{$id}\" name=\"{$name}\">\n";
        }
        foreach ($options as $value => $key) {
            if ($selected == $value) {
                $text .= "\t<option valute=\"{$value}\" selected=\"selected\">{$key}</option>\n";
            } elseif ($selected === false) {
                $text .= "\t<option value=\"{$value}\">{$key}</option>\n";
            }
        }
        $text .= '</select>';
        $label = $this->form_label($label_name, $label_for);
        $form_item = $this->form_item($label, $text);
        return $form_item;
    }
    //多选列表函数
    public function form_selectmul($id, $name, $size, $options = array(), $label_name, $label_for)
    {
        $text = "<select id=\"{$id}\" name=\"{$name}\" size=\"{$size}\" multiple=\"multiple\">\n";
        foreach ($options as $value => $key) {
            $text .= "\t<option value=\"{$value}\">{$key}</option>\n";
        }
        $text .= '</select>
';
        $label = $this->form_label($label_name, $label_for);
        $form_item = $this->form_item($label, $text);
        return $form_item;
    }
    //按钮函数
    public function form_button($id, $name, $type, $value, $onclick = '')
    {
        $text = "<button id=\"{$id}\" name=\"{$name}\" type=\"{$type}\"";
        if ($onclick !== '') {
            $text .= " onclick='{$onclick}'";
        }
        $text .= '>' . $value;
        $text .= '</button>
';
        if ($this->layout == true) {
            $form_item = "<tr>\n\t<th> </th><td>{$text}</td>\n</tr>\n";
        } else {
            $form_item = $text;
        }
        return $form_item;
    }
    //文本域函数
    public function form_textarea($id, $name, $cols, $rows, $label_name, $label_for, $value = '')
    {
        $text = "<textarea id=\"{$id}\" name=\"{$name}\" cols=\"{$cols}\" rows=\"{$rows}\">{$value}</textarea>\n";
        $label = $this->form_label($label_name, $label_for);
        $form_item = $this->form_item($label, $text);
        return $form_item;
    }
    //文字标签函数
    public function form_label($text, $for)
    {
        if ($for !== '') {
            $label = "<label for=\"{$for}\">{$text}：</label>";
        } else {
            $label = $text . '：';
        }
        return $label;
    }
    public function form_item($form_label, $form_text)
    {
        switch ($this->layout) {
            case true:
                $text = '<tr>';
                $text .= '	<th class="label">';
                $text .= $form_label;
                $text .= '</th>';
                $text .= '	<td>';
                $text .= $form_text;
                $text .= '</td>';
                $text .= '</tr>';
                break;
            case false:
                $text = $form_label;
                $text .= $form_text;
                break;
        }
        return $text;
    }

}