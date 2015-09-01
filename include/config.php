<?php
//计算花费时间 count cost time
$startime  = microtime();

//显示所有错误，警告提示
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);//取消警告
//error_reporting(0);//取消所有错误提示

//是否显示调试信息 show debug info 说明：1为显示，其他为不显示
define('SHOW_DEBUG', 0);

//是否服务器模式
define('SERVER_MODE', 1);

//数据库查询次数 query count
$query_count = 0;

//版本检测
if (version_compare(PHP_VERSION, '5.1.0', '<')) die('本系统需要PHP版本为5.1以上，你的版本为：' . PHP_VERSION . "，请升级你的PHP版本。");
	
//数据库定义 Database Define
define('DB_TYPE',       'mysql5');
define('DB_USER',       'mingyihuinet_f');
define('DB_PASS',       'hkyxZ8z4St');
define('DB_HOST',       'localhost');
define('DB_PORT',       '3333');
define('DB_NAME',       'mingyihuitest');
define('DB_LANG',       'UTF8');
define('DB_TABLE_PRE',  'monolithpro_');	
//-----------------------------------------------------------

//系统版本 $site_version
$site_version = 'V2011-5';

//网站物理路径 site dir 最后都不要加斜杠
define('SITE_DIR', '/var/www/web1/mingyihuitest');
define('SITE_URL', 'http://www.mingyihui.net');
define('WAP_SITE_URL', 'http://m.mingyihui.net');
define('SITE_TITLE',      '名医汇');
define('SITE_FOLDER',     '');

//网站导航
define('SITE_NAV',  '<a href="'.SITE_URL .'">首页 &gt;&gt;</a> ');

//日志
define('SITE_LOG',  SITE_DIR . 'log.log');

//常规设置
//页面跳转时间(秒)
define('REFRESH_TIME',5);

//当前页
define('THISPAGE', $_SERVER ['PHP_SELF']);

//baidumap key
define('BAIDUMAPKEY', 'IfgzY5Bdi09Lme2py5AL3kwf');
//-----------------------------------------------------------

/**
 * 默认账号设置
 */
define('ADMINUSER','');
define('ADMINPASS','');

define('USERNAME', '');
define('PASSWORD', '');

//默认组
define('GROUPID',13);
//默认权限
define('PERMISSION',524440);

/**
 * 系统各个模块设置
 */
//默认时区
date_default_timezone_set('PRC');

//返回自从 Unix 纪元（格林威治时间 1970 年 1 月 1 日 00:00:00）到当前时间的秒数。
define('TIMESTAMP', $_SERVER['REQUEST_TIME']);

///////////////
//Cookies方面//
///////////////
//COOKIE有效目录，使一个空间放置多个论坛,都能访问!
define('DB_CKPATH','/');

//COOKIE有效域名
define('DB_CKDOMAIN','.mingyihui.net');

////////////////////
//00全局变量////////
////////////////////
$titletitle='';
$titledesc='';
$titlekeywords='';

define('MAX_PAGE', 76); 

////////////////////
//01广告模块////////
////////////////////
define('ADV_FORDER', '/adv/');
define('ADV_CATEID', 1); 

////////////////////
//02轮显模块////////
////////////////////
define('CYCLE_FORDER', '/cycle/');
define('CYCLECATEID',   1); //轮显Cateid

////////////////////
//03评论模块////////
////////////////////
define('COMMENT',      0);
define('COMMENTS',     10);   //默认显示的评论条数
define('COMMENTCHECK', 0);    //是否需要审核

////////////////////
//04模板模快////////
////////////////////
define('TP',        '/templates/default/');
define('TPURL',     SITE_URL.'/templates/default/');
define('TPCACHING', 1);  //0不缓存、1缓存
define('TPTIME'   , 3600);
define('TPONLY' ,md5($_SERVER['REQUEST_URI']));

////////////////////
//05投票模快////////
////////////////////
define('TIMEOUT', 3600);

////////////////////
//07用户管理模块////
////////////////////
define('USER_CK_TIME',   30 * 24 * 60 * 60);    //默认的超时时间30天， 24小时 = 1天
define('NICKNAME_TIME',   30 * 24 * 60 * 60);   //用户修改头像间隔时间，默认时间30天， 24小时 = 1天

define('PERSONPIC',   '/images/person.jpg');    //用户默认头像-原图
define('PERSONPICB',  '/images/personb.jpg');   //用户默认头像-大图
define('PERSONPICS',  '/images/persons.jpg');   //用户默认头像-小图


define('H_WIDTH',  120); //头像宽度
define('H_HEIGHT', 90 ); //头像高度

////////////////////
//06文件上传模块////
////////////////////
define('UPLOADURL',     '/upload/');
define('UPLOADPATH',   SITE_DIR . UPLOADURL);
define('UPLOAD_MAX',   2048);                //最大上传文件大小， 以K为单位
define('UPLOAD_EXT',   '.gif,.jpg,.png, ');  //允许上传的附件
define('UPLOAD_FILES', 4);                   //最大上传文件个数

////////////////////
//11导航模块////////
////////////////////
define('NAV_FORDER', '/nav/');
define('NAV_CATEID', 1); 

////////////////////
//12文章模块////////
////////////////////
define('ARTICLEHTML',        0);  //是否静态地址
define('ARTICLEHTMLURL',     'article.php?id=');     //是否静态地址
define('ARTICLEHTMLLISTURL', 'articlelist.php?id='); //是否静态地址

define('ARTICLEURL',    'article/');
define('ARTICLEPATH',    SITE_DIR . ARTICLEURL);

define('CATEURL',        'cate/');
define('CATEPATH',      SITE_DIR . CATEURL);

define('ARTICLEGUIDECOUNT', 23);   //首页新闻中心条数

define('ARTICLE_FLAG',     2);      //前台显示的状态
define('EDTFLAG',          1);      //添加、修改后Flag
define('ISSUEFLAG',        2);      //发布后Flag
define('ARTICLE_PAGESIZE', 12);     //每页显示记录数
define('ARTICLE_SHOWRS',   14);     //显示翻页

define('ARTICLE_EXPERT_CATEID',   26);     //专家观点栏目编号

////////////////////
//13医院管理////////
////////////////////
define('WORKEY',    '◆');  //标识字符
define('imgDoctor',     '/img/doctor.gif');     //默认医生图标
define('imgDepartment', '/img/department.gif'); //默认部门图标
define('imgHospital',   '/img/hospital.jpg');   //默认医院图标

define('DOCTORCOMMENT_PAGESIZE', 8);           //医生评论显示条数
define('SEARCH_PAGESIZE', 5);                   //搜索显示条数

define('HOSPITALLIST_PAGESIZE',   10);           //医院列表页
define('DEPARTMENTLIST_PAGESIZE', 10);           //科室医生列表页

$areaArr = array (
  1 => '华东',
  2 => '华南',
  3 => '华北',
  4 => '西南',
  5 => '东北',
  6 => '西北',
  7 => '中部'
);

$provArr = array(
  1  => '北京市',
  2  => '广东省',
  3  => '上海市',
  4  => '天津市',
  5  => '河北省',
  6  => '山西省',
  7  => '内蒙古自治区',
  8  => '辽宁省',
  9  => '吉林省',
  10 => '黑龙江省',
  11 => '江苏省',
  12 => '浙江省',
  13 => '安徽省',
  14 => '福建省',
  15 => '江西省',
  16 => '山东省',
  17 => '河南省',
  18 => '湖北省',
  19 => '湖南省',
  20 => '广西壮族自治区',
  21 => '海南省',
  22 => '重庆市',
  23 => '四川省',
  24 => '贵州省',
  25 => '云南省',
  26 => '西藏自治区',
  27 => '陕西省',
  28 => '甘肃省',
  29 => '青海省', 
  30 => '宁夏回族自治区', 
  31 => '新疆维吾尔自治区',  
  
);

$provSpellArr = array(
  1  => 'beijing',      //1  => '北京市',
  2  => 'guangdong',    //2  => '广东省',
  3  => 'shanghai',     //3  => '上海市',
  4  => 'tianjin',      //4  => '天津市',
  5  => 'hebei',        //5  => '河北省',
  6  => 'sx',           //6  => '山西省',
  7  => 'neimenggu',    //7  => '内蒙古自治
  8  => 'liaoning',     //8  => '辽宁省',
  9  => 'jilinshen',    //9  => '吉林省',
  10 => 'heilongjiang', //10 => '黑龙江省',
  11 => 'jiangsu',      //11 => '江苏省',
  12 => 'zhejiang',     //12 => '浙江省',
  13 => 'anhui',        //13 => '安徽省',
  14 => 'fujian',       //14 => '福建省',
  15 => 'jiangxi',      //15 => '江西省',
  16 => 'shandong',     //16 => '山东省',
  17 => 'henan',        //17 => '河南省',
  18 => 'hubei',        //18 => '湖北省',
  19 => 'hunan',        //19 => '湖南省',
  20 => 'guangxi',      //20 => '广西壮族自治区',
  21 => 'hainan',       //21 => '海南省',
  22 => 'chongqing',    //22 => '重庆市',
  23 => 'sichuan',      //23 => '四川省',
  24 => 'guizhou',      //24 => '贵州省',
  25 => 'yunnan',       //25 => '云南省',
  26 => 'xizang',       //26 => '西藏自治区'
  27 => 'shanxi',       //27 => '陕西省',
  28 => 'gansu',        //28 => '甘肃省',
  29 => 'qinghai',      //29 => '青海省', 
  30 => 'ningxia',      //30 => '宁夏回族自治区', 
  31 => 'xinjiang',     //31 => '新疆维吾尔自治区',
 );

////////////////////
//15采集管理////////
////////////////////
define('STIME',      20);   //超时
define('SLEEPTIME',  2);    //采集休息时间
define('SPERPAGE',   2);   //每次采集数
define('SMODE',      2);    //1为file_get_content 2为fsockopen
define('tingzhenID', 13);   //停诊信息栏目
define('SNATCHTIME', 10 * 24 * 60 * 60 );        //10天才能再次采集

//网站导航
define('ARTICLE_NAV',     '<a href="'.SITE_URL . '/article.html">文章首页 &gt;</a> ');

////水印设置
define('WATERMARK',    1); //1打水印，0不打
define('WATERMARKPIC',  SITE_DIR."/img/logo.png");  //水印地址， 建议采用PNG图片， 这样透明效果更好


//是否启用日志，TRUE为启用
define('ISLOG', TRUE);


//usertype 用户类型
$userTypeArr = array (1 => '患者',  2 => '医生',  3 => '服务商');


//盐
define('SALT', 'mingyihui'); //

//360检测
if(is_file($_SERVER['DOCUMENT_ROOT'].'/360safe/360webscan.php')){
    require_once($_SERVER['DOCUMENT_ROOT'].'/360safe/360webscan.php');
}
?>
