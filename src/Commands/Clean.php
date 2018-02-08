<?php
namespace Apidoc\Commands;

use Apidoc\ApiDocServiceProvider;
use Apidoc\Log;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Created by PhpStorm.
 * User: zhangwei
 * Date: 18-1-25
 * Time: 下午6:03
 */
class Clean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:cleanall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command clean docs!';

    protected $toolbox;

    public function __construct()
    {
        parent::__construct();
        $this->toolbox = app()->getProvider(ApiDocServiceProvider::class)->getToolbox();
    }

    public function handle() {
        Log::setCommand($this);
        $fileSystem = new Filesystem();
        $outPath = $this->toolbox->getRender()->getOutputPath();
        if(is_dir($outPath)) {
            if($fileSystem->deleteDirectory($outPath)) {
                Log::info("删除所有文档和测试文件:".$outPath);
            } else {
                Log::error("删除所有文档和测试文件 失败:".$outPath);
            }
        } else {
            Log::info("删除所有文档和测试文件:".$outPath);
        }
    }

}