<?php
namespace Apidoc;

class DocToolBox {

    private $desc;
    private $render;

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getRender()
    {
        return $this->render;
    }

    /**
     * @param mixed $render
     */
    public function setRender($render)
    {
        $this->render = $render;
    }


}