<?php if(!defined('BASEPATH')) exit('脚本文件不允许直接访问');
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-7
 * Time: 下午6:38
 * To change this template use File | Settings | File Templates.
 */
class CI_config{
    var $config=array();
    var $is_loaded=array();
    var $_config_paths=array(APPPATH);
    function __construct(){
        $this->config=&get_config();
        log_message('debug','配置文件类已经被初始化');
        if($this->config['base_url']==''){
            if(isset($_SERVER['HTTP_HOST'])){

            }
        }
    }
}