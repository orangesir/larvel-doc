<?php
namespace Apidoc\Descriptions\DefaultDesc;

use Apidoc\Descriptions\AbstractDescription;
use Apidoc\Exceptions\DocIgnoreException;
use Apidoc\Exceptions\UndefinedMarkException;
use Apidoc\Log;
use Illuminate\Support\Facades\Route;

class DefaultDescription extends AbstractDescription {

    public $depth = 0;

    private $groupNameList = array();

    public function extraDesc()
    {

        yield $this->getTileItem();

        $routes = $this->getRoutes();
        foreach ($routes as $route) {
            try {
                $docs = $this->routeDocs($route);
            } catch (DocIgnoreException $e) {
                //有忽略标记的接口不在返回信息给渲染工具
                continue;
            }
            foreach ($docs as $doc) {
                yield $doc;
            }
        }

    }

    private function getTileItem() {
        return [
            "type" => "group",
            "depth"=> $this->depth,
            "Name" => "接口文档"
        ];
    }

    private function routeDocs($route) {
         $docs = [];
         $groupTitle = $this->groupTilte($route);

         //跨分组时使用
         if(count($groupTitle)<count($this->groupNameList)) {
             $this->groupNameList = array_slice($this->groupNameList,0,count($groupTitle));
         }

         //有分组
         for ($i=0;$i<count($groupTitle);$i++) {
             $name = trim($groupTitle[$i]);
             if(isset($this->groupNameList[$i])) {
                if($name===$this->groupNameList[$i]) {
                    continue;
                } else {
                    $this->groupNameList = array_slice($this->groupNameList,0, $i);
                }
             }
             $this->groupNameList[] = $name;
             $docs[] = [
                 "type" => "group",
                 "depth"=> $i+1,
                 "Name" => $name
             ];
         }
         $docs[] = $this->extraApi($route);

         Log::info("完成解析接口:".$route->methods[0]." ".$route->uri);

         return $docs;
    }

    private function extraApi($route) {
        return array_merge($this->extraRoute($route), $this->extraCodeComments($route));
    }

    private function extraRoute($route) {
        return [
            "type" => "api",
            "depth"=> $this->takeDepth($this->groupTilte($route)),
            "request_path" => $route->uri,
            "request_method" => $route->methods[0],
        ];
    }

    public function extraCodeComments($route) {
        return (new ApiCodeCommentsParser($route->action["uses"]))->parse();
    }

    private function groupTilte($route) {
        $key = "grouptitle";
        $groupTitle = empty($route->action[$key])?[]:$route->action[$key];
        if(is_string($groupTitle)) {
            return [$groupTitle];
        }
        return $groupTitle;
    }

    private function takeDepth($groupTitle) {
        return count($groupTitle)+1;
    }

    public function getRoutes() {
        return Route::getRoutes();
    }



}