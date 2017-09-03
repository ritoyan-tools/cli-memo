<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;

class DoCommand extends Command
{
    protected function configure()
    {
        $this->setName("do")
            ->setDescription("标记当前备忘录的某条备忘为已完成")
            ->addArgument(
                'shortName', InputArgument::REQUIRED, '备忘录标识'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $shortName = $input->getArgument("shortName");
        $flag = Memo::doMemo($shortName, $fullName);
        if ($flag) {
            $info = "备忘[{$shortName} => {$fullName}]标记已完成成功";
        } else {
            $info = "备忘[{$shortName} => {$fullName}]标记已完成失败";
        }
        $output->writeln($info);
    }
}
