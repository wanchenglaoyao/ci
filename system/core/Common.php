<?php if(!defined('BASEPATH')) exit('不能直接访问脚本文件');
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-3
 * Time: 下午6:29
 * To change this template use File | Settings | File Templates.
 */
if(!function_exists('_exception_handler')){
    function _exception_handler($severity,$message,$filepath,$line){
        if($severity==E_STRICT){
            return ;
        }
        $_error=& load_class('Exceptions','core');
        if(($severity & error_reporting())==$severity){
            $_error->show_php_error($severity,$message,$filepath,$line);
        }
        if(config_item('log_threshold')==0){
            return ;
        }
        $_error->log_exception($severity,$message,$filepath,$line);
    }
}
//版本比较注意如果当前的版本过低的话返回的是false；
if(!function_exists('is_php')){
    function is_php($version='5.0.0'){
        static $_is_php;
        $version=(string)$version;
        if(!isset($_is_php[$version])){
            $_is_php[$version]=(version_compare(PHP_VERSION,$version)<0)?FALSE:TRUE;
        }
        return $_is_php[$version];
    }
}
if(!function_exists('is_loaded')){
    function &is_loaded($class=''){
        if($class!=''){
            $_is_loaded[strtolower($class)]=$class;
        }
        return $_is_loaded;
    }
}
if(!function_exists('config_item')){
    function config_item($item){
        static $_config_item=array();
        if(!isset($_config_item[$item])){
            $config=& get_config();
            if(!isset($config[$item])){
                return false;
            }
            $_config_item[$item]=$config[$item];
        }
        return $_config_item[$item];
    }
}
if(!function_exists('get_config')){
    function &get_config($replace=array()){
        static $_config;
        if(isset($_config)){
            return $_config[0];
        }
        if(!defined('ENVIRONMENT') OR !file_exists($file_path=APPPATH.'config/'.ENVIRONMENT.'config.php')){
            $file_path=APPPATH.'config/config.php';
        }
        if(!file_exists($file_path)){
            exit('配置文件的路径不存在');
        }
        require($file_path);
        if(!isset($config) or !is_array($config)){
            exit('配置文件设置不正确');
        }
        if(count($replace)>0){
            foreach($replace as $key =>$value){
                if(isset($config[$key])){
                   $config[$key]=$value;
                }
            }
        }
        return $_config[0]=&$config;
    }
}
if(!function_exists('show_404')){
    function show_404(){

    }
}
if(!function_exists('load_class')){
    function &load_class($class,$directory='libraries',$prefix='CI_'){
        static $_classes=array();
        if(isset($_class[$class])){
            return $_classes[$class];
        }
        $name=false;
        //为啥会有break因为存在覆盖的情况
        foreach(array(APPPATH,BASEPATH) as $path){
            if(file_exists($path.$directory.'.'.$class.'.php')){
                $name=$prefix.$class;
                if(class_exists($name)===false){
                    require($path.$directory.'/'.$class.'.php');
                }
                break;
            }
        }
        if(file_exists(APPPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php')){
            $name=config_item('subclass_prefix').$class;
            if(class_exists($name)===false){
                require(APPPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php');
            }
        }
        if($name===false){
           exit('无法找到指定的类'.$class.'.php');
        }
        is_loaded($class);
        $_classes[$class]=new $name;
        return $_classes;
    }
}