<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;

class ShowCommand extends Command
{
    protected function configure()
    {
        $this->setName("show")
            ->setDescription("列出当前备忘录所有备忘。");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memos = Memo::showMemo();
        foreach ($memos as $shortName => $memo) {
            $status = $memo["status"];
            if ($status == "init") {
                $info = "  {$shortName} {$memo['memo']}";
            } else if($status == "done") {
                $info = "◼︎ {$shortName} {$memo['memo']}";
            }
            $output->writeln($info);
        }
    }
}
