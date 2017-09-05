<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;

class CreateCommand extends Command
{
    protected function configure()
    {
        $this->setName("create")
            ->setDescription("创建新的备忘录")
            ->addArgument(
                'memoName', InputArgument::REQUIRED, '新备忘录名称。'
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO 判断是否已经存在了
        $memoName = $input->getArgument("memoName");
        $flag = Memo::createMemo($memoName);
        if ($flag) {
            $output->writeln("<info>创建新的备忘录[{$memoName}]成功</info>");
        } else {
            $output->writeln("<error>创建新的备忘录[{$memoName}]失败</error>");
        }
    }
}
