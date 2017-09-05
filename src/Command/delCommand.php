<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;
use Aizuyan\Memo\Exception\MemoException;

class DelCommand extends Command
{
    protected function configure()
    {
        $this->setName("del")
            ->setDescription("删除备忘录")
            ->addArgument(
                'shortName', InputArgument::REQUIRED, '新备忘录名称。'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $shortName = $input->getArgument("shortName");
        $memos = Memo::listAllMemo();
        $memos = Memo::memoInfos();
        if (!isset($memos[$shortName])) {
            throw new MemoException("\n <error>备忘录[{$shortName}]不存在</error>\n", 1);
        }

        $nowMemoName = Memo::getNowMemoName();
        if (Memo::getMemoShortName($nowMemoName) == $memos[$shortName]) {
            throw new MemoException("\n <error>当前在要删除的备忘录[{$shortName} => $nowMemoName], 不可删除当前备忘录</error>\n", 1);
        }
        $flag = Memo::delMemo($memos[$shortName]);
        if ($flag) {
            $info = "<info>删除备忘录[{$shortName} => ".$memos[$shortName]."]成功</info>";
        } else {
            $info = "<error>删除备忘录[{$shortName} => ".$memos[$shortName]."]失败</error>";
        }
        $output->writeln($info);
    }
}
