<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;
use Aizuyan\Memo\Exception\MemoException;

class DoCommand extends Command
{
    protected function configure()
    {
        $this->setName("done")
            ->setDescription("标记当前备忘录的某条备忘为已完成")
            ->addArgument(
                'shortName', InputArgument::REQUIRED, '备忘录标识'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $shortName = $input->getArgument("shortName");
        $memos = Memo::showMemo();
        $nowMemoName = Memo::getNowMemoName();
        if (!isset($memos[$shortName])) {
            throw new MemoException("\n  <error>当前备忘录[{$nowMemoName}]不存在[{$shortName}]备忘</error>\n", 1);
        }
        $flag = Memo::doMemo($shortName, $fullName);
        if ($flag) {
            $info = "<info>备忘[{$shortName} => {$fullName}]标记已完成成功<info>";
        } else {
            $info = "<error>备忘[{$shortName} => {$fullName}]标记已完成失败<error>";
        }
        $output->writeln($info);
    }
}
