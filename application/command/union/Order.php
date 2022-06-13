<?php


namespace app\command\union;


use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class Order extends Command
{
    protected function configure()
    {
        $this->setName('syn_order')
            ->setDescription('同步订单,如php think syn_order pdd 30')
            ->setHelp('php think syn_order')
            ->addArgument('a',Argument::REQUIRED,'类型：pdd-拼多多，tb-淘宝，vip-唯品会，jd-京东')
            ->addArgument('b',Argument::OPTIONAL,'多少分钟的订单');

    }

    protected function execute(Input $input, Output $output)
    {

        $type = $input->getArgument('a');
        $minute = $input->getArgument('b');
        $output->writeln("type：".$type);
        $output->writeln("minute：".$minute);
    }
}

