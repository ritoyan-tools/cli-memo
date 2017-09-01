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
        $output->writeln("备忘录1");
        $output->writeln("备忘录3");
        $output->writeln("备忘录2");
        Memo::listAllMemo();
    }
}
