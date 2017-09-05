<?php
namespace Aizuyan\Memo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Aizuyan\Memo\Memo;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class HelpCommand extends Command
{
    protected function configure()
    {
        $this->setName("help")
            ->setDescription("帮助信息");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helpDoc = <<<ET
  create    name                        创建新的备忘录
  change    short name                  切换备忘录
  del       short name                  删除备忘录

  add       memo string                 给当前的备忘录添加一条记录
  done      memo string short name      标记当前备忘录的某条备忘为已完成

  show                                  列出当前备忘录所有备忘
  list                                  列出所有的备忘录名称
ET;
        $output->writeln($helpDoc);

    }
}
