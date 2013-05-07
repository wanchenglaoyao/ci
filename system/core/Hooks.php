<?php   if(!defined('BASEPATH')) exit('脚本文件不允许直接访问');
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-7
 * Time: 下午5:57
 * To change this template use File | Settings | File Templates.
 */
class CI_Hooks{
    var $enabled=false;
    var $hooks  =array();
    var $in_progress=false;
    function __construct(){
        $this->_initialize();
        log_message('debug','钩子类初始化完成');
    }
    function _initialize(){
        //首先加载配置文件类
        $CFG=&load_class('Config','core');
        if($CFG->item('enable_hooks')==false){
            return;
        }
        //加载钩子类
        if(defined('ENVIRONMENT') and is_file(APPPATH.'config/'.ENVIRONMENT.'hooks.php')){
            include(APPPATH.'config/'.ENVIRONMENT.'hooks.php');
        }elseif(is_file(APPPATH.'config/hooks.php')){
            include(APPPATH.'config/hooks.php');
        }
        //查看钩子类有没有数组
        if(!isset($hook) or !is_array($hook)){
           return;
        }
        $this->hooks=& $hook;
        $this->enabled=TRUE;
    }
    function _call_hook($which=''){
        if(!$this->enabled or !isset($this->hooks[$which])){
            return false;
        }
        if(isset($this->hooks[$which][0]) and is_array($this->hooks[$which][0])){
            foreach($this->hooks[$which] as $val){
                $this->_run_hooks[$val];
            }
        }else{
            $this->_run_hooks[$which];
        }
        return true;
    }
    function _run_hooks($data){
        if(!is_array($data)){
            return false;
        }
        if($this->in_progress==true){
            return;
        }
        if(!isset($data['filepath']) or !isset($data['filename'])){
            return false;
        }
        $filepath=APPPATH.$data['filepath'].'/'.$data['filename'];
        if(!file_exists($filepath)){
            return false;
        }
        $clas     =false;
        $function =false;
        $params   ='';
        if(isset($data['class']) and $data['class'] != ''){
            $class=$data['class'];
        }
        if(isset($data['function']) ){
            $function=$data['function'];
        }
        if($class===FALSE and $function===false){
            return false;
        }
        $this->in_progress=true;
        if($class!==false){
            if(!class_exists($class)){
                require($filepath);
            }
            $HOOK=new $class;
            $HOOK->$function($params);
        }else{
            if(!function_exists($function)){
                require($filepath);
            }
            $function($params);
        }
        $this->in_progress=false;
        return true;
    }
}