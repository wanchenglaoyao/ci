<?php  if(!defined('BASEPATH')) exit('不允许直接访问脚本文件！');
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-3
 * Time: 下午6:20
 * To change this template use File | Settings | File Templates.
 */
define('CI_VERSION','2.1.3');
define('CI_CORE',FALSE);
require(BASEPATH.'core/Common.php');
//包括常量文件
if(defined('ENVIRONMENT') and file_exists(APPPATH.'config/'.ENVIRONMENT.'/constants.php')){
    require(APPPATH.'config/'.ENVIRONMENT.'/constants.php');
}else{
    require(APPPATH.'config/constants.php');
}
set_error_handler('_exception_handler');
//为什么版本低于5.3，要关闭转义的功能呢？
if(!is_php('5.3')){
   @set_magic_quotes_runtime(0);
}
if(isset($assign_to_config['subclass_prefix']) and $assign_to_config['subclass_prefix']!=''){
    get_config(array('subclass_prefix'=>$assign_to_config['subclass_prefix']));
}
if(function_exists('set_time_limit')==TRUE AND @ini_get('safe_mode')==0){
    @set_time_limit(300);
}

$BM=&load_class('Benchmark','core');
$BM->mark('total_execution_time_start');
$BM->mark('loading_time:_base_classes_start');

$EXT =& load_class('Hooks', 'core');
$EXT->_call_hook('pre_system');

$EXT=&load_class('Hooks','core');
$EXT->_call_hook('pre_system');
$CFG=&load_class('Config','core');
if(isset($assign_to_config)){
    $CFG->_assign_to_config($assign_to_config);
}
$UNI=&load_class('utf8','core');
$URI=&load_class('URI','core');
$RTR=&load_class('Router','core');
$RTR->_set_routing();
if(isset($routing)){
    $RTR->_set_overrides($routing);
}








