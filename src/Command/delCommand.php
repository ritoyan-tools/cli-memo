<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;

class DelCommand extends Command
{
    protected function configure()
    {
        $this->setName("del")
            ->setDescription("删除备忘录")
            ->addArgument(
                'memoShortName', InputArgument::REQUIRED, '新备忘录名称。'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memoShortName = $input->getArgument("memoShortName");
        $memos = Memo::listAllMemo();
        $nowMemo = Memo::getNowMemoName();
        if (Memo::getMemoShortName($nowMemo) == $memoShortName) {
            $output->writeln("删除失败，当前在[{nowMemo}]备忘录");
            return;
        }
        $flag = false;
        foreach ($memos as $value) {
            $shortName = Memo::getMemoShortName($value);
            if ($shortName == $memoShortName) {
                $flag = Memo::delMemo($value);
                break;
            }
        }
        if ($flag) {
            $info = "删除备忘录[{$value}]成功";
        } else {
            $info = "删除备忘录[{$value}]失败";
        }
        $output->writeln($info);
    }
}
