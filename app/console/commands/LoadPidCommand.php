<?php declare(strict_types = 1);

namespace VstupniTest\App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DescriptorHelper;
use Symfony\Component\Console\Question\Question;

class LoadPidCommand extends Command
{
    public function configure(): void
    {
        $this->setName('load:pid')
            ->setDescription('load pids from json file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string|null $pwUuid */
        $pwUuid = $input->getArgument('pw_uuid');
        $output->writeln("<info>healthCheck started</info>");


        return 0;
    }
}
