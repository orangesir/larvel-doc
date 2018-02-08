<?php
namespace Apidoc;

use Apidoc\Commands\Clean;
use Apidoc\Commands\Generate;
use Apidoc\Descriptions\DefaultDesc\DefaultDescription;
use Apidoc\Renders\DefaultRender\DefaultRender;
use Illuminate\Support\ServiceProvider;

class ApiDocServiceProvider extends ServiceProvider {

    private $toolbox;

    public function boot() {
        //初始化使用
        $this->app["view"]->addLocation($this->getResourcesPath());

        $this->toolbox = new DocToolBox();
        $this->toolbox->setRender($this->getRender());
        $this->toolbox->setDesc($this->getDesc());


        $this->toolbox->getRender()->setOutputPath($this->outputPath());
        $this->toolbox->getRender()->setResourcesPath(rtrim($this->getResourcesPath(), DIRECTORY_SEPARATOR));
    }

    public function register() {
        $this->app->singleton('doc.generate', function () {
            return new Generate();
        });
        $this->app->singleton('doc.clean', function () {
            return new Clean();
        });
        $this->commands([
            'doc.generate',
            'doc.clean'
        ]);
    }

    private function getResourcesPath() {
        return config("doc.resources", __DIR__ . "/../resources");
    }

    private function outputPath() {
        return config("doc.output",  app()->basePath().'/public/docs');
    }

    private function getRender() {
        $renderClass = config("doc.renderclass", DefaultRender::class);
        return new $renderClass();
    }

    private function getDesc()
    {
        $descClass = config("doc.descclass", DefaultDescription::class);
        return new $descClass();
    }

    public static function getCustomMarks() {
        $customMarks = config("doc.custommarks", []);
        if(is_array($customMarks)) {
            return $customMarks;
        }
        return [];
    }

    public static function getTpl() {
        return config("doc.blade.php","doc.blade.php");
    }

    /**
     * @return mixed
     */
    public function getToolbox()
    {
        return $this->toolbox;
    }

}
