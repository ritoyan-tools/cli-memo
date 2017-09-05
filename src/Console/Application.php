<?php

namespace Aizuyan\Memo\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Aizuyan\Memo\Memo;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;

class Application extends BaseApplication
{
    const NAME = "cli-mome";
    const VERSION = "1.0.0";
    public function __construct()
    {
        parent::__construct(self::NAME, self::VERSION);
		Memo::initPathVar();
		parent::setCatchExceptions(false);
    }

    /**
     * 不加载系统的命令
     * @return [type] [description]
     */
    protected function getDefaultCommands()
    {
        return array();
    }    
}
