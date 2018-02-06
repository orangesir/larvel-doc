<?php
namespace Apidoc\Descriptions;

abstract class AbstractDescription {

    /**
     *
     * 提取描述
     * 如果前一次返回的group,接下来的几次如果深度大于这个次的group深度，那么接下来几次就是这个group的子分组或者接口
     *
     * 层级关系图:
     *   所有接口:                       depth=0
     *      接口1                       depth=1
     *      group2                     depth=1
     *         接口21                   depth=2
     *         接口22                   depth=2;
     *         group23                 depth=2
     *            ......               depth=3 ....
     *      group3                     depth=1
     *         接口31                   depth=2
     *      接口4                       depth=1
     *     ........
     *
     * @yield group
     * [
     * "type" => $type,                             //返回类型，"group"代表返回接口分组, "api"代表单个接口
     * "depth"=> $depth,                            //从所有接口开始0开始，1，2.....
     * "Name" => $name,                             //接口组名，有可能没有
     * ]
     * 或者
     * @yield api
     * [
     *     "type" => $type                         //返回类型，"group"代表返回接口分组, "api"代表单个接口
     *     "Name" => $name,                        //接口名，有可能没有
     *     "depth"=> $depth,                       //从所有接口 1开始，2，3.....
     *     "request_path" => $path,                //请求路径如 /api/auth/login
     *     "request_method" => $method,            //请求方法如 get,post,put,delete
     *     "Description" => $desc,                //接口描述如 这个接口是做什么的,什么时候调用，需不需要登录等等
     *     "Param" => [
     *          "$param_1" => [
     *               "name"=>$name,                //参数的key,获取方式$_GET[$name],$_POST[$name]
     *               "value"=>$valuedesc,          //参数值描述
     *               "testvalue"=>$testvalue       //参数测试值
     *           ],
     *          "$param_2" => [
     *               "name"=>$name,                //参数的key,获取方式$_GET[$name],$_POST[$name]
     *               "value"=>$valuedesc,          //参数值描述
     *               "testvalue"=>$testvalue       //参数测试值
     *           ],
     *           ......                            //参数三到参数n
     *     ],
     *     "Response" => $response_desc,      //返回值 描述
     * ]
     */
    public abstract function extraDesc();
}