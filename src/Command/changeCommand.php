<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;

class ChangeCommand extends Command
{
    protected function configure()
    {
        $this->setName("change")
            ->setDescription("切换备忘录")
            ->addArgument(
                'memoName', InputArgument::REQUIRED, '要切换的备忘录名称。'
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memoName = $input->getArgument("memoName");
        $flag = Memo::changeMemo($memoName);
        if ($flag) {
            $output->writeln("切换备忘录[{$memoName}]成功。");
        } else {
            $output->writeln("切换备忘录[{$memoName}]失败。");
        }
    }
}
