<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-3
 * Time: 下午5:57
 * To change this template use File | Settings | File Templates.
 */
    define('ENVIRONMENT','development');
    if(defined('ENVIRONMENT')){
        switch (ENVIRONMENT)
        {
            case 'development':
                error_reporting(E_ALL);
                break;
            case 'testing':
            case 'production':
                error_reporting(0);
                break;
            default:
                exit('项目环境没有设置成功。');
        }
    }
    $system_path="system";
    $application_folder="application";
    if(defined('STDIN')){
       chdir(dirname(__FILE__));
    }
    if(realpath($system_path)){
        $system_path=realpath($system_path);
    }
    $system_path=rtrim($system_path,'/').'/';
    if(!is_dir($system_path)){
        exit('你的系统文件夹设置有错误。');
    }
    define('SELF',pathinfo(__FILE__,PATHINFO_BASENAME));
    define('EXT','.php');
    define('BASEPATH',str_replace('\\','/',$system_path));
    define('FCPATH',str_replace(SELF,'',__FILE__));
    define('SYSDIR',trim(strrchr(trim(BASEPATH,'/'),'/'),'/'));
    //从这里说明了项目文件夹可以移植到system目录下面去
    if(is_dir($application_folder)){
        define('APPPATH',$application_folder.'/');
    }else{
        if(!is_dir(BASEPATH.$application_folder.'/')){
            exit('你的项目文件夹设置不正确');
        }
        define('APPPATH',BASEPATH.$application_folder.'/');
    }
    require_once BASEPATH.'core/CodeIgniter.php';
