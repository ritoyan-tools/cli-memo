<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;
use Aizuyan\Memo\Exception\MemoException;

class ChangeCommand extends Command
{
    protected function configure()
    {
        $this->setName("change")
            ->setDescription("切换备忘录")
            ->addArgument(
                'shortName', InputArgument::REQUIRED, '要切换的备忘录名称。'
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $shortName = $input->getArgument("shortName");
        $memos = Memo::memoInfos();
        if (!isset($memos[$shortName])) {
            throw new MemoException("\n <error>备忘录[{$shortName}]不存在</error>\n", 1);
        }
        $memoName = $memos[$shortName];
        $flag = Memo::changeMemo($memoName);
        if ($flag) {
            $output->writeln("<info>切换备忘录[$shortName => {$memoName}]成功</info>");
        } else {
            $output->writeln("<error>切换备忘录[$shortName => {$memoName}]失败</error>");
        }
    }
}
