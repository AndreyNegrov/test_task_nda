<?php

declare(strict_types=1);

namespace App\UI\Console;

use App\Application\UseCase\TrackCurrency;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:start-tracking', description: 'Get exchange rates')]
class StartTrackingCommand extends Command
{
    public function __construct(
        private readonly TrackCurrency $getExchangeRates,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getExchangeRates->process();

        return Command::SUCCESS;
    }
}