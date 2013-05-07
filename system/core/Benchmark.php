<?php if(!defined('BASEPATH')) exit('脚本文件不允许直接访问');
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-7
 * Time: 下午5:44
 * To change this template use File | Settings | File Templates.
 */
class CI_Benchmark{
    var  $marker=array();
    function mark($name){
        $this->marker[$name]=microtime();
    }
}