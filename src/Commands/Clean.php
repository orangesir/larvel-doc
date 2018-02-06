<?php
namespace Apidoc\Commands;

use Apidoc\Log;
use Illuminate\Console\Command;

/**
 * Created by PhpStorm.
 * User: zhangwei
 * Date: 18-1-25
 * Time: 下午6:03
 */
class Clean extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    public function handle() {
        Log::setCommand($this);
    }

}