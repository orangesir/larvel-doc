<?php
namespace Apidoc;

class Log {

    private static $command;

    /**
     * @return mixed
     */
    public static function getCommand()
    {
        return self::$command;
    }

    /**
     * @param mixed $command
     */
    public static function setCommand($command)
    {
        self::$command = $command;
    }

    public static function error($info) {
        if(self::getCommand()) {
            self::$command->error($info);
        } else {
            echo $info."\n";
        }
    }

    public static function info($info) {
        if(self::getCommand()) {
            self::$command->info($info);
        } else {
            echo $info."\n";
        }

    }

}