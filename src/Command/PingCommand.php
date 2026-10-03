<?php

namespace App\Command;

use App\Message\Ping;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'app:ping', description: 'Dispatch one Ping message to the async transport')]
final class PingCommand
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function __invoke(OutputInterface $output): int
    {
        $id = bin2hex(random_bytes(4));
        $this->bus->dispatch(new Ping($id, date(DATE_ATOM)));
        $output->writeln("dispatched Ping id={$id}");

        return Command::SUCCESS;
    }
}
