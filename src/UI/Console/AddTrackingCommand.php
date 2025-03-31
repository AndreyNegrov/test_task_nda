<?php

declare(strict_types=1);

namespace App\UI\Console;

use App\Domain\UseCase\AddTrackingInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:add-tracking', description: 'Add currency pair tracking')]
class AddTrackingCommand extends Command
{
    public function __construct(
        private readonly AddTrackingInterface $addTracking,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'base-currency',
            InputArgument::REQUIRED,
            'Base currency code'
        );

        $this->addArgument(
            'target-currency',
            InputArgument::REQUIRED,
            'Target currency code'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->addTracking->process(
            $input->getArgument('base-currency'),
            $input->getArgument('target-currency')
        );

        return Command::SUCCESS;
    }
}
