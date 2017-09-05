<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;

class InitCommand extends Command
{
    protected function configure()
    {
        $this->setName("init")
            ->setDescription("初始化当前用户备忘录环境");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memoInfo = $input->getArgument("memoInfo");
        $flag = Memo::addMemo($memoInfo);
        if ($flag) {
            $info = "添加备忘[{$memoInfo}]成功";
        } else {
            $info = "添加备忘[{$memoInfo}]失败";
        }
        $output->writeln($info);
    }
}
