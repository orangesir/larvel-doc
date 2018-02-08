<?php
namespace Apidoc\Renders\DefaultRender;

use Apidoc\ApiDocServiceProvider;
use Apidoc\Exceptions\DocException;
use Apidoc\Log;
use Apidoc\Renders\AbstractRender;

class DefaultRender extends AbstractRender {

    private $tpl;
    private $apiInfoList = [];

    /**
     * 完成初始化render接口之前的工作
     *   如单页显示所有api，render页面header....
     * @return mixed
     */
    public function before()
    {
        $tpl = $this->getResourcesPath().DIRECTORY_SEPARATOR.$this->getTpl();
        if(!file_exists($tpl)) {
            throw new DocException("doc.blade.php not exist! file:".$tpl);
        }
        if(!is_readable($tpl)) {
            throw new DocException("doc.blade.php is not readable! file:".$tpl);
        }
        $this->tpl = $tpl;

        if(!is_dir($this->getOutputPath())) {
            if(!mkdir($this->getOutputPath())) {
                throw new DocException("mkdir out path failure. dir:".$this->getOutputPath());
            }
        }
        if(!is_writable($this->getOutputPath())) {
            throw new DocException("out path is not writeable! dir:".$this->getOutputPath());
        }
        if(!is_dir($this->getOutputPath().DIRECTORY_SEPARATOR."tests")) {
            if(!mkdir($this->getOutputPath().DIRECTORY_SEPARATOR."tests")) {
                throw new DocException("mkdir tests dir in out path failure. dir:".$this->getOutputPath());
            }
        }
        if(!is_writable($this->getOutputPath().DIRECTORY_SEPARATOR."tests")) {
            throw new DocException("test dir in out path is not writeable! dir:".$this->getOutputPath());
        }
    }

    /**
     * render一个api或者group信息
     *   如把这些信息写入文件，或者post到其它第三方接口，或者保存到内存中
     * @param $apiInfo 接口信息
     * @return mixed
     */
    public function render($apiInfo)
    {
        $apiInfo["id"] = uniqid();
        $this->apiInfoList[] = $apiInfo;
        if($apiInfo["type"]=="api") {
            $outTestFile =  $this->getOutputPath().DIRECTORY_SEPARATOR."tests".DIRECTORY_SEPARATOR.$apiInfo["id"].".html";
            file_put_contents($outTestFile,view("test", ["info"=>$apiInfo]));
            Log::info("生成接口测试工具:".$apiInfo["request_method"]." ".$apiInfo["request_path"]);
        }
    }

    /**
     * 完成所有接口render完成之后的工作
     *    如单页显示所有api，render页面footer....
     *    或者把保存到内存中的所有接口信息，做处理（写入文件，传给第三方接口等等）
     * @return mixed
     */
    public function after()
    {
        // 写入文件
        $outStyleFile = $this->getOutputPath().DIRECTORY_SEPARATOR."style.css";
        $stylefile = $this->getResourcesPath().DIRECTORY_SEPARATOR."style.css";
        if(file_exists($stylefile) && is_readable($stylefile)) {
            file_put_contents($outStyleFile,file_get_contents($stylefile));
        }

        //request.js
        $outRequestjsFile = $this->getOutputPath().DIRECTORY_SEPARATOR."tests".DIRECTORY_SEPARATOR."request.js";
        $requestjsFile = $this->getResourcesPath().DIRECTORY_SEPARATOR."request.js";
        if(file_exists($requestjsFile) && is_readable($requestjsFile)) {
            file_put_contents($outRequestjsFile,file_get_contents($requestjsFile));
        }

        $outDocFile = $this->getOutputPath().DIRECTORY_SEPARATOR."index.html";

        file_put_contents($outDocFile,view("doc", ["apiinfo"=>$this->apiInfoList]));
        Log::info("完成文档写入，文档文件:".$outDocFile);
    }

    public function getTpl() {
        return ApiDocServiceProvider::getTpl();
    }
}