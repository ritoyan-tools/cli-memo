<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;

class LsCommand extends Command
{
    protected function configure()
    {
        $this->setName("ls")
            ->setDescription("列出所有的备忘录名称");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memos = Memo::listAllMemo();
        $nowMemo = Memo::getNowMemoName();
        $lastShow = "";
        foreach ($memos as $value) {
            $memo = "";
            $shortName = Memo::getMemoShortName($value);
            if ($value == $nowMemo) {
                $lastShow .= "* {$shortName} <info>{$nowMemo}</info>";
                continue;
            } else {
                $memo .= "  {$shortName} {$value}";
            }
            $output->writeln($memo);
        }
        $output->writeln("{$lastShow}");
    }
}
