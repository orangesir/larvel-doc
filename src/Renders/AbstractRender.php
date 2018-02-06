<?php
namespace Apidoc\Renders;

abstract class AbstractRender {

    protected $outputPath;
    protected $resourcesPath;

    /**
     * 完成初始化render接口之前的工作
     *   如单页显示所有api，render页面header....
     * @return mixed
     */
    public abstract function before();

    /**
     * render一个api或者group信息
     *   如把这些信息写入文件，或者post到其它第三方接口，或者保存到内存中
     * @param $apiInfo 接口信息
     * @return mixed
     */
    public abstract function render($apiInfo);

    /**
     * 完成所有接口render完成之后的工作
     *    如单页显示所有api，render页面footer....
     *    或者把保存到内存中的所有接口信息，做处理（写入文件，传给第三方接口等等）
     * @return mixed
     */
    public abstract function after();

    /**
     * @return mixed
     */
    public function getOutputPath()
    {
        return $this->outputPath;
    }

    /**
     * @param mixed $outputPath
     */
    public function setOutputPath($outputPath)
    {
        $this->outputPath = $outputPath;
    }

    /**
     * @return mixed
     */
    public function getResourcesPath()
    {
        return $this->resourcesPath;
    }

    /**
     * @param mixed $resourcesPath
     */
    public function setResourcesPath($resourcesPath)
    {
        $this->resourcesPath = $resourcesPath;
    }


}