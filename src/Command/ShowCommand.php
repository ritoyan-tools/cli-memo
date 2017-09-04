<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ShowCommand extends Command
{
    protected function configure()
    {
        $this->setName("show")
            ->setDescription("列出当前备忘录所有备忘。");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $titleStyle = new OutputFormatterStyle("green", "default", ["bold"]);
        $subTitleStyle = new OutputFormatterStyle("cyan", "default");
        $memoName = Memo::getNowMemoName();
        $memos = Memo::showMemo();
        $dones = [];
        $output->writeln($titleStyle->apply("{$memoName}"));
        $output->writeln($subTitleStyle->apply("  待完成事项:"));
        foreach ($memos as $shortName => $memo) {
            $status = $memo["status"];
            if ($status == "init") {
                $info = "    ☞  <info>{$shortName} {$memo['memo']}</info>";
            } else if($status == "done") {
                $dones[] = "    ✔  {$shortName} {$memo['memo']}";
                continue;
            }
            $output->writeln($info);
        }
        $output->writeln($subTitleStyle->apply("  已完成事项:"));
        foreach ($dones as $value) {
            $output->writeln($value);
        }
    }
}
