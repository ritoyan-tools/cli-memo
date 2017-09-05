<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;
use Aizuyan\Memo\Exception\MemoException;

class InitCommand extends Command
{
    protected function configure()
    {
        $this->setName("init")
            ->setDescription("初始化当前用户备忘录环境");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $flag = Memo::isInit();
        if ($flag) {
            throw new MemoException("\n  <info>已经初始化过了</info>\n", 1);
        }

        $ret = Memo::init();
        if ($ret) {
            $output->writeln("<info>初始化成功</info>");
        } else {
            $output->writeln("<error>初始化失败</error>");
        }
    }
}
