<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class LsCommand extends Command
{
    protected function configure()
    {
        $this->setName("ls")
            ->setDescription("列出所有的备忘录名称");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $titleStyle = new OutputFormatterStyle("green", "default", ["bold"]);
        $output->writeln($titleStyle->apply("备忘录列表"));
        $memos = Memo::listAllMemo();
        $nowMemo = Memo::getNowMemoName();
        $shortName = Memo::getMemoShortName($nowMemo);
        $firstShow = "  ☞  <info>{$shortName} {$nowMemo}</info>";
        $output->writeln("{$firstShow}");
        foreach ($memos as $value) {
            $memo = "";
            $shortName = Memo::getMemoShortName($value);
            if ($value == $nowMemo) {
                continue;
            } else {
                $memo .= "     {$shortName} {$value}";
            }
            $output->writeln($memo);
        }
    }
}
